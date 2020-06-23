<?php

namespace Botble\Media;

use Botble\Media\Http\Resources\FileResource;
use Illuminate\Support\Facades\Auth;
use Botble\Media\Repositories\Interfaces\MediaFileInterface;
use Botble\Media\Repositories\Interfaces\MediaFolderInterface;
use Botble\Media\Services\UploadsManager;
use Botble\Media\Services\ThumbnailService;
use Exception;
use File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Image;
use Storage;
use Throwable;

class RvMedia
{

    /**
     * @var array
     */
    protected $permissions = [];

    /**
     * @var UploadsManager
     */
    protected $uploadManager;

    /**
     * @var MediaFileInterface
     */
    protected $fileRepository;

    /**
     * @var MediaFolderInterface
     */
    protected $folderRepository;

    /**
     * @var ThumbnailService
     */
    protected $thumbnailService;

    /**
     * @param MediaFileInterface $fileRepository
     * @param MediaFolderInterface $folderRepository
     * @param UploadsManager $uploadManager
     * @param ThumbnailService $thumbnailService
     */
    public function __construct(
        MediaFileInterface $fileRepository,
        MediaFolderInterface $folderRepository,
        UploadsManager $uploadManager,
        ThumbnailService $thumbnailService
    ) {
        $this->fileRepository = $fileRepository;
        $this->folderRepository = $folderRepository;
        $this->uploadManager = $uploadManager;
        $this->thumbnailService = $thumbnailService;

        $this->permissions = config('core.media.media.permissions', []);
    }

    /**
     * @return string
     * @throws Throwable
     */
    public function renderHeader()
    {
        $urls = $this->getUrls();
        return view('core/media::header', compact('urls'))->render();
    }

    /**
     * Get all urls
     * @return array
     */
    public function getUrls()
    {
        return [
            'base_url'                 => asset(''),
            'base'                     => route('media.index'),
            'get_media'                => route('media.list'),
            'create_folder'            => route('media.folders.create'),
            'get_quota'                => route('media.quota'),
            'popup'                    => route('media.popup'),
            'download'                 => route('media.download'),
            'upload_file'              => route('media.files.upload'),
            'add_external_service'     => route('media.files.add_external_service'),
            'get_breadcrumbs'          => route('media.breadcrumbs'),
            'global_actions'           => route('media.global_actions'),
            'media_upload_from_editor' => route('media.files.upload.from.editor'),
        ];
    }

    /**
     * @return string
     * @throws Throwable
     */
    public function renderFooter()
    {
        return view('core/media::footer')->render();
    }

    /**
     * @return string
     * @throws Throwable
     */
    public function renderContent()
    {
        return view('core/media::content')->render();
    }

    /**
     * @param $data
     * @param null $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseSuccess($data, $message = null)
    {
        return response()->json([
            'error'   => false,
            'data'    => $data,
            'message' => $message,
        ]);
    }

    /**
     * @param $message
     * @param array $data
     * @param null $code
     * @param int $status
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseError($message, $data = [], $code = null, $status = 200)
    {
        return response()->json([
            'error'   => true,
            'message' => $message,
            'data'    => $data,
            'code'    => $code,
        ], $status);
    }

    /**
     * @param $url
     * @return array|mixed
     */
    public function getAllImageSizes($url)
    {
        $images = [];
        foreach (RvMedia::getSizes() as $size) {
            $readableSize = explode('x', $size);
            $images = get_image_url($url, $readableSize);
        }

        return $images;
    }

    /**
     * @return array
     */
    public function getSizes(): array
    {
        return config('core.media.media.sizes', []);
    }

    /**
     * @param $fileUpload
     * @param int $folderId
     * @param string $path
     * @return \Illuminate\Http\JsonResponse|array
     */
    public function handleUpload($fileUpload, $folderId = 0, $path = '')
    {
        if (!$fileUpload) {
            return [
                'error'   => true,
                'message' => __('File is invalid!'),
            ];
        }

        /**
         * @var UploadedFile $fileUpload
         */
        try {
            $file = $this->fileRepository->getModel();

            if ($fileUpload->getSize() / 1024 > (int)config('core.media.media.max_file_size_upload')) {
                return [
                    'error'   => true,
                    'message' => trans('core/media::media.file_too_big',
                        ['size' => config('core.media.media.max_file_size_upload')]),
                ];
            }

            $fileExtension = $fileUpload->getClientOriginalExtension();

            $file->name = $this->fileRepository->createName(File::name($fileUpload->getClientOriginalName()),
                $folderId);

            $folderPath = $this->folderRepository->getFullPath($folderId, $path);

            $fileName = $this->fileRepository->createSlug($file->name, $fileExtension, Storage::path($folderPath));

            $filePath = $fileName;

            if ($folderPath) {
                $filePath = $folderPath . '/' . $filePath;
            }

            $content = File::get($fileUpload->getRealPath());

            $this->uploadManager->saveFile($filePath, $content);

            $data = $this->uploadManager->fileDetails($filePath);

            if (empty($data['mime_type'])) {
                return [
                    'error'   => true,
                    'message' => trans('core/media::media.can_not_detect_file_type'),
                ];
            }

            $file->url = $data['url'];
            $file->size = $data['size'];
            $file->mime_type = $data['mime_type'];

            $file->folder_id = $folderId;
            $file->user_id = Auth::check() ? Auth::user()->getKey() : 0;
            $file->options = request()->get('options', []);
            $this->fileRepository->createOrUpdate($file);

            if ($file->canGenerateThumbnails()) {
                foreach (config('core.media.media.sizes', []) as $size) {
                    $readableSize = explode('x', $size);
                    $this->thumbnailService
                        ->setImage($fileUpload->getRealPath())
                        ->setSize($readableSize[0], $readableSize[1])
                        ->setDestinationPath($folderPath)
                        ->setFileName(File::name($fileName) . '-' . $size . '.' . $fileExtension)
                        ->save();
                }

                if (config('core.media.media.watermark.source')) {
                    $image = Image::make(public_path($file->url));
                    $image->insert(
                        config('core.media.media.watermark.source'),
                        config('core.media.media.watermark.position', 'bottom-right'),
                        config('core.media.media.watermark.x', 10),
                        config('core.media.media.watermark.y', 10)
                    );
                    $image->save(public_path($file->url));
                }
            }

            return [
                'error' => false,
                'data'  => new FileResource($file),
            ];
        } catch (Exception $ex) {
            return [
                'error'   => true,
                'message' => $ex->getMessage(),
            ];
        }
    }

    /**
     * @return array
     */
    public function getPermissions()
    {
        return $this->permissions;
    }

    /**
     * @param array $permissions
     */
    public function setPermissions(array $permissions)
    {
        $this->permissions = $permissions;
    }

    /**
     * @param $permission
     */
    public function removePermission($permission)
    {
        Arr::forget($this->permissions, $permission);
    }

    /**
     * @param $permission
     */
    public function addPermission($permission)
    {
        $this->permissions[] = $permission;
    }

    /**
     * @param $permission
     * @return bool
     */
    public function hasPermission($permission)
    {
        return in_array($permission, $this->permissions);
    }

    /**
     * @param array $permissions
     * @return bool
     */
    public function hasAnyPermission(array $permissions)
    {
        $hasPermission = false;
        foreach ($permissions as $permission) {
            if (in_array($permission, $this->permissions)) {
                $hasPermission = true;
                break;
            }
        }

        return $hasPermission;
    }

    /**
     * Returns a file size limit in bytes based on the PHP upload_max_filesize and post_max_size
     * @return float|int
     */
    public function getServerConfigMaxUploadFileSize()
    {
        // Start with post_max_size.
        $maxSize = $this->parseSize(ini_get('post_max_size'));

        // If upload_max_size is less, then reduce. Except if upload_max_size is
        // zero, which indicates no limit.
        $uploadMax = $this->parseSize(ini_get('upload_max_filesize'));
        if ($uploadMax > 0 && $uploadMax < $maxSize) {
            $maxSize = $uploadMax;
        }

        return $maxSize;
    }

    /**
     * @param $size
     * @return float - bytes
     */
    public function parseSize($size)
    {
        $unit = preg_replace('/[^bkmgtpezy]/i', '', $size); // Remove the non-unit characters from the size.
        $size = preg_replace('/[^0-9\.]/', '', $size); // Remove the non-numeric characters from the size.
        if ($unit) {
            // Find the position of the unit in the ordered string which is the power of magnitude to multiply a kilobyte by.
            return round($size * pow(1024, stripos('bkmgtpezy', $unit[0])));
        }

        return round($size);
    }

    /**
     * @param $path
     * @return string
     */
    public function url($path)
    {
        if (Str::contains($path, 'https://')) {
            return $path;
        }

        return Storage::url($path);
    }

    /**
     * @return string
     */
    public function getSize(string $name): ?string
    {
        return config('core.media.media.sizes.' . $name);
    }

    /**
     * @param string $name
     * @param int $width
     * @param int $height
     * @return $this
     */
    public function addSize(string $name, int $width, int $height)
    {
        config(['core.media.media.sizes.' . $name => $width . 'x' . $height]);

        return $this;
    }
}
