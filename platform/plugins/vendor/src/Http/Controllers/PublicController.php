<?php

namespace Botble\Vendor\Http\Controllers;

use Assets;
use Botble\Base\Enums\BaseStatusEnum;
use Botble\Payment\Http\Requests\AfterMakePaymentRequest;
use Botble\Payment\Models\Payment;
use Botble\Payment\Services\Gateways\PayPal\PayPalPaymentService;
use Botble\Vendor\Http\Resources\PackageResource;
use Botble\Vendor\Http\Resources\VendorResource;
use Botble\Vendor\Repositories\Interfaces\PackageInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Media\Http\Requests\MediaFileRequest;
use Botble\Media\Repositories\Interfaces\MediaFileInterface;
use Botble\Media\Services\ThumbnailService;
use Botble\Media\Services\UploadsManager;
use Botble\Vendor\Http\Requests\AvatarRequest;
use Botble\Vendor\Http\Requests\SettingRequest;
use Botble\Vendor\Http\Requests\UpdatePasswordRequest;
use Botble\Vendor\Repositories\Interfaces\VendorActivityLogInterface;
use Botble\Vendor\Repositories\Interfaces\VendorInterface;
use Exception;
use File;
use Hash;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Routing\Controller;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use RvMedia;
use SeoHelper;
use Illuminate\Support\Facades\Validator;

class PublicController extends Controller
{
    /**
     * @var VendorInterface
     */
    protected $accountRepository;

    /**
     * @var VendorActivityLogInterface
     */
    protected $activityLogRepository;

    /**
     * @var MediaFileInterface
     */
    protected $fileRepository;

    /**
     * PublicController constructor.
     * @param Repository $config
     * @param VendorInterface $accountRepository
     * @param VendorActivityLogInterface $accountActivityLogRepository
     * @param MediaFileInterface $fileRepository
     */
    public function __construct(
        Repository $config,
        VendorInterface $accountRepository,
        VendorActivityLogInterface $accountActivityLogRepository,
        MediaFileInterface $fileRepository
    ) {
        $this->accountRepository = $accountRepository;
        $this->activityLogRepository = $accountActivityLogRepository;
        $this->fileRepository = $fileRepository;

        Assets::setConfig($config->get('plugins.vendor.assets'));
    }

    /**
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function getDashboard()
    {
        $user = auth()->guard('vendor')->user();

        SeoHelper::setTitle(auth()->guard('vendor')->user()->getFullName());

        return view('plugins/vendor::dashboard.index', compact('user'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function getSettings()
    {
        SeoHelper::setTitle(__('Account settings'));

        $user = auth()->guard('vendor')->user();

        return view('plugins/vendor::settings.index', compact('user'));
    }

    /**
     * @param SettingRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse|\Illuminate\Http\RedirectResponse
     */
    public function postSettings(SettingRequest $request, BaseHttpResponse $response)
    {
        $year = $request->input('year');
        $month = $request->input('month');
        $day = $request->input('day');

        if ($year && $month && $day) {
            $request->merge(['dob' => implode('-', [$year, $month, $day])]);

            $validator = Validator::make($request->input(), [
                'dob' => 'nullable|date',
            ]);

            if ($validator->fails()) {
                return redirect()->route('public.vendor.settings');
            }
        }

        $this->accountRepository->createOrUpdate($request->except('email'),
            ['id' => auth()->guard('vendor')->user()->getKey()]);

        $this->activityLogRepository->createOrUpdate(['action' => 'update_setting']);

        return $response
            ->setNextUrl(route('public.vendor.settings'))
            ->setMessage(__('Update profile successfully!'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function getSecurity()
    {
        SeoHelper::setTitle(__('Security'));

        return view('plugins/vendor::settings.security');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getPackages()
    {
        SeoHelper::setTitle(__('Packages'));

        return view('plugins/vendor::settings.package');
    }

    /**
     * @param PackageInterface $packageRepository
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function ajaxGetPackages(PackageInterface $packageRepository, BaseHttpResponse $response)
    {
        $account = $this->accountRepository->findOrFail(Auth::guard('vendor')->user()->getAuthIdentifier(), ['package']);

        $packages = $packageRepository->advancedGet([
            'condition' => [
                'status' => BaseStatusEnum::PUBLISHED,
                ['id', '!=', $account->package_id],
                ['price', '>=', $account->package_id ? $account->package->price : 0],
            ],
        ]);

        return $response->setData([
            'packages' => PackageResource::collection($packages),
            'account'  => new VendorResource($account),
        ]);
    }

    /**
     * @param Request $request
     * @param PackageInterface $packageRepository
     * @param BaseHttpResponse $response
     */
    public function ajaxSubscribePackage(
        Request $request,
        PackageInterface $packageRepository,
        BaseHttpResponse $response
    ) {
        $package = $packageRepository->findOrFail($request->input('id'));

        if ($package->price) {
            if (setting('payment_paypal_status') != 1 && setting('payment_stripe_status') != 1) {
                return $response->setError()->setMessage(__('Please setup payment gateway (PayPal & Stripe)'));
            }

            return $response->setData(['next_page' => route('public.vendor.package.subscribe', $package->id)]);
        }

        $account = Auth::guard('vendor')->user();
        $account->package_id = $package->id;
        $account->package_start_date = now();
        $account->package_end_date = now()->addDays($package->number_of_days);
        $account->package_available_quota = $package->number_of_listings;
        $account->save();

        $account = $this->accountRepository->findOrFail(Auth::guard('vendor')->user()->getAuthIdentifier(), ['package']);

        return $response->setData(new VendorResource($account));
    }

    /**
     * @param $id
     * @param PackageInterface $packageRepository
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getSubscribePackage($id, PackageInterface $packageRepository)
    {
        $package = $packageRepository->findOrFail($id);

        SeoHelper::setTitle(__('Subscribe package ":name"', ['name' => $package->name]));

        Assets::addStylesDirectly('vendor/core/plugins/payment/libraries/card/card.css')
            ->addStylesDirectly('vendor/core/plugins/payment/css/payment.css')
            ->addScriptsDirectly('vendor/core/plugins/payment/libraries/card/card.js')
            ->addScriptsDirectly('https://js.stripe.com/v2/')
            ->addScriptsDirectly('vendor/core/plugins/payment/js/payment.js');

        return view('plugins/vendor::checkout', compact('package'));
    }

    /**
     * @param $packageId
     * @param AfterMakePaymentRequest $request
     * @param PayPalPaymentService $payPalService
     * @param PackageInterface $packageRepository
     * @return RedirectResponse
     */
    public function getPackageSubscribeCallback(
        $packageId,
        AfterMakePaymentRequest $request,
        PayPalPaymentService $payPalService,
        PackageInterface $packageRepository
    ) {
        $package = $packageRepository->findOrFail($packageId);

        if ($request->input('type') == Payment::METHOD_PAYPAL) {
            $paymentStatus = $payPalService->getPaymentStatus($request);
            if ($paymentStatus == true) {
                $payPalService->afterMakePayment($request);

                $account = Auth::guard('vendor')->user();
                $account->package_id = $package->id;
                $account->save();

                return redirect()->to(route('public.vendor.packages'))->with('success_msg',
                    trans('plugins/payment::payment.checkout_success'));
            }

            return redirect()->to(route('public.vendor.packages'))->with('error_msg',
                $payPalService->getErrorMessage());
        }

        $account = Auth::guard('vendor')->user();
        $account->package_id = $package->id;
        $account->package_start_date = now();
        $account->package_end_date = now()->addDays($package->number_of_days);
        $account->package_available_quota = $package->number_of_listings;
        $account->save();

        return redirect()->to(route('public.vendor.packages'))->with('success_msg',
            trans('plugins/payment::payment.checkout_success'));
    }

    /**
     * @param UpdatePasswordRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function postSecurity(UpdatePasswordRequest $request, BaseHttpResponse $response)
    {
        if (!Hash::check($request->input('current_password'), auth()->guard('vendor')->user()->getAuthPassword())) {
            return $response
                ->setError()
                ->setMessage(trans('plugins/vendor::dashboard.current_password_not_valid'));
        }

        $this->accountRepository->update(['id' => auth()->guard('vendor')->user()->getKey()], [
            'password' => bcrypt($request->input('password')),
        ]);

        $this->activityLogRepository->createOrUpdate(['action' => 'update_security']);

        return $response->setMessage(trans('plugins/vendor::dashboard.password_update_success'));
    }

    /**
     * @param AvatarRequest $request
     * @param UploadsManager $uploadManager
     * @param ImageManager $imageManager
     * @param ThumbnailService $thumbnailService
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function postAvatar(
        AvatarRequest $request,
        UploadsManager $uploadManager,
        ImageManager $imageManager,
        ThumbnailService $thumbnailService,
        BaseHttpResponse $response
    ) {
        try {
            $fileUpload = $request->file('avatar_file');

            $file_ext = $fileUpload->getClientOriginalExtension();

            $folderPath = 'vendors';

            $fileName = $this->fileRepository->createName(File::name($fileUpload->getClientOriginalName()), 0);

            $fileName = $this->fileRepository->createSlug($fileName, $file_ext, Storage::path($folderPath));

            $account = $this->accountRepository->findOrFail(Auth::guard('vendor')->user()->getKey());

            $image = $imageManager->make($request->file('avatar_file')->getRealPath());
            $avatarData = json_decode($request->input('avatar_data'));
            $image->crop((int)$avatarData->height, (int)$avatarData->width, (int)$avatarData->x, (int)$avatarData->y);
            $path = $folderPath . '/' . $fileName;

            $uploadManager->saveFile($path, $image->stream()->__toString());

            $readable_size = explode('x', RvMedia::getSize('thumb'));

            $thumbnailService
                ->setImage($fileUpload->getRealPath())
                ->setSize($readable_size[0], $readable_size[1])
                ->setDestinationPath($folderPath)
                ->setFileName(File::name($fileName) . '-' . RvMedia::getSize('thumb') . '.' . $file_ext)
                ->save();

            $data = $uploadManager->fileDetails($path);

            $file = $this->fileRepository->getModel();
            $file->name = $fileName;
            $file->url = $data['url'];
            $file->size = $data['size'];
            $file->mime_type = $data['mime_type'];
            $file->folder_id = 0;
            $file->user_id = 0;
            $file->options = [];
            $file = $this->fileRepository->createOrUpdate($file);

            $this->fileRepository->forceDelete(['id' => $account->avatar_id]);

            $account->avatar_id = $file->id;

            $this->accountRepository->createOrUpdate($account);

            $this->activityLogRepository->createOrUpdate([
                'action' => 'changed_avatar',
            ]);

            return $response
                ->setMessage(trans('plugins/vendor::dashboard.update_avatar_success'))
                ->setData(['url' => Storage::url($data['url'])]);
        } catch (Exception $ex) {
            return $response
                ->setError()
                ->setMessage($ex->getMessage());
        }
    }

    /**
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function getActivityLogs(BaseHttpResponse $response)
    {
        $activities = $this->activityLogRepository->getAllLogs(auth()->guard('vendor')->user()->getKey());

        foreach ($activities->items() as &$activity) {
            $activity->description = $activity->getDescription();
        }

        return $response->setData($activities);
    }

    /**
     * @param MediaFileRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function postUpload(MediaFileRequest $request, BaseHttpResponse $response)
    {
        $result = RvMedia::handleUpload(Arr::first($request->file('file')), 0, 'vendors');

        if ($result['error']) {
            return $response->setError();
        }

        return $response->setData($result['data']);
    }

    /**
     * @param MediaFileRequest $request
     * @return mixed
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function postUploadFromEditor(MediaFileRequest $request)
    {
        $result = RvMedia::handleUpload($request->file('upload'), 0, 'vendors');

        if ($result['error'] == false) {
            $file = $result['data'];
            return response('<script>parent.setImageValue("' . get_image_url($file->url) . '"); </script>')->header('Content-Type',
                'text/html');
        }

        return response('<script>alert("' . Arr::get($result, 'message') . '")</script>')->header('Content-Type',
            'text/html');
    }
}
