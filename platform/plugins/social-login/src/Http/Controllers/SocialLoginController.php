<?php

namespace Botble\SocialLogin\Http\Controllers;

use Assets;
use Botble\Vendor\Repositories\Interfaces\VendorInterface;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Facades\Auth;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Setting\Supports\SettingStore;
use Botble\SocialLogin\Http\Requests\SocialLoginRequest;
use Exception;
use Illuminate\View\View;
use Laravel\Socialite\AbstractUser;
use Socialite;

class SocialLoginController extends BaseController
{

    /**
     * Redirect the user to the {provider} authentication page.
     *
     * @param string $provider
     * @return mixed
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from {provider}.
     * @param string $provider
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function handleProviderCallback($provider, BaseHttpResponse $response)
    {
        try {
            /**
             * @var AbstractUser $oAuth
             */
            $oAuth = Socialite::driver($provider)->user();
        } catch (Exception $ex) {
            return $response
                ->setError()
                ->setNextUrl(route('public.vendor.login'))
                ->setMessage($ex->getMessage());
        }

        $user = app(VendorInterface::class)->getFirstBy(['email' => $oAuth->getEmail()]);

        if (!$user) {
            $user = app(VendorInterface::class)->createOrUpdate([
                'first_name'  => $oAuth->first_name,
                'last_name'   => $oAuth->last_name,
                'email'       => $oAuth->email,
                'verified_at' => now(),
                'password'    => bcrypt(Str::random(36)),
            ]);
        }

        Auth::guard('vendor')->login($user, true);

        return $response
            ->setNextUrl(route('public.vendor.dashboard'))
            ->setMessage(trans('core/acl::auth.login.success'));
    }

    /**
     * @return Factory|View
     */
    public function getSettings()
    {
        page_title()->setTitle(trans('plugins/social-login::social-login.settings.title'));

        Assets::addScriptsDirectly('vendor/core/plugins/social-login/js/social-login.js');

        return view('plugins/social-login::settings');
    }

    /**
     * @param SocialLoginRequest $request
     * @param BaseHttpResponse $response
     * @param SettingStore $setting
     * @return BaseHttpResponse
     */
    public function postSettings(SocialLoginRequest $request, BaseHttpResponse $response, SettingStore $setting)
    {
        foreach ($request->except(['_token']) as $setting_key => $setting_value) {
            $setting->set($setting_key, $setting_value);
        }

        $setting->save();

        return $response
            ->setPreviousUrl(route('social-login.settings'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }
}
