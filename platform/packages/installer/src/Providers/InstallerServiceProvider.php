<?php

namespace Botble\Installer\Providers;

use Botble\Base\Supports\Helper;
use Botble\Base\Traits\LoadAndPublishDataTrait;
use Botble\Installer\Http\Middleware\CheckIfInstalledMiddleware;
use Botble\Installer\Http\Middleware\CheckIfInstallingMiddleware;
use Botble\Installer\Http\Middleware\RedirectIfNotInstalledMiddleware;
use Illuminate\Support\ServiceProvider;

class InstallerServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register()
    {
        if (!config('app.key')) {
            config(['app.key' => 'base64:jPDTWLGPka60Lg927hn8Qcxt9ZiuAiXT3XZAf8mwWu4=']);
        }

        Helper::autoload(__DIR__ . '/../../helpers');
    }

    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function boot()
    {
        $router = $this->app->make('router');

        $router->middlewareGroup('install', [CheckIfInstalledMiddleware::class]);
        $router->middlewareGroup('installing', [CheckIfInstallingMiddleware::class]);
        $router->pushMiddlewareToGroup('web', RedirectIfNotInstalledMiddleware::class);

        $this->setNamespace('packages/installer')
            ->loadAndPublishConfigurations('installer')
            ->loadAndPublishTranslations()
            ->loadAndPublishViews()
            ->loadRoutes(['web'])
            ->publishAssets();
    }
}
