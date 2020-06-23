<?php

namespace Botble\DevTool\Providers;

use Botble\DevTool\Commands\InstallCommand;
use Botble\DevTool\Commands\LocaleCreateCommand;
use Botble\DevTool\Commands\LocaleRemoveCommand;
use Botble\DevTool\Commands\Make\ControllerMakeCommand;
use Botble\DevTool\Commands\Make\FormMakeCommand;
use Botble\DevTool\Commands\Make\ModelMakeCommand;
use Botble\DevTool\Commands\Make\RepositoryMakeCommand;
use Botble\DevTool\Commands\Make\RequestMakeCommand;
use Botble\DevTool\Commands\Make\RouteMakeCommand;
use Botble\DevTool\Commands\Make\TableMakeCommand;
use Botble\DevTool\Commands\PackageCreateCommand;
use Botble\DevTool\Commands\RebuildPermissionsCommand;
use Botble\DevTool\Commands\TestSendMailCommand;
use Botble\DevTool\Commands\TruncateTablesCommand;
use Botble\DevTool\Commands\UserCreateCommand;
use Botble\DevTool\Commands\PackageMakeCrudCommand;
use Illuminate\Support\ServiceProvider;

class CommandServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                TableMakeCommand::class,
                ControllerMakeCommand::class,
                RouteMakeCommand::class,
                RequestMakeCommand::class,
                FormMakeCommand::class,
                ModelMakeCommand::class,
                RepositoryMakeCommand::class,
                PackageCreateCommand::class,
                PackageMakeCrudCommand::class,
                InstallCommand::class,
                TestSendMailCommand::class,
                TruncateTablesCommand::class,
                UserCreateCommand::class,
                RebuildPermissionsCommand::class,
                LocaleRemoveCommand::class,
                LocaleCreateCommand::class,
            ]);
        }
    }
}
