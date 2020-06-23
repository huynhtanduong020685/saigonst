<?php

namespace Botble\DevTool\Commands;

use Botble\DevTool\Commands\Abstracts\BaseMakeCommand;
use File;
use Illuminate\Support\Str;
use League\Flysystem\FileNotFoundException;

class PackageCreateCommand extends BaseMakeCommand
{
    /**
     * The console command signature.
     *
     * @var string
     */
    protected $signature = 'cms:package:create {name : The package name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a package in the /platform/packages directory.';

    /**
     * Execute the console command.
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     * @throws FileNotFoundException
     */
    public function handle()
    {
        if (!preg_match('/^[a-z0-9\-]+$/i', $this->argument('name'))) {
            $this->error('Only alphabetic characters are allowed.');
            return false;
        }

        $package = strtolower($this->argument('name'));
        $location = package_path($package);

        if (File::isDirectory($location)) {
            $this->error('A package named [' . $package . '] already exists.');
            return false;
        }

        $this->publishStubs($this->getStub(), $location);
        $this->renameFiles($package, $location);
        $this->searchAndReplaceInFiles($package, $location);
        $this->line('------------------');
        $this->line('<info>The package</info> <comment>' . $package . '</comment> <info>was created in</info> <comment>' . $location . '</comment><info>, customize it!</info>');
        $this->line('------------------');
        $this->call('cache:clear');

        return true;
    }

    /**
     * @return string
     */
    public function getStub(): string
    {
        return __DIR__ . '/../../stubs/module';
    }

    /**
     * @param string $replaceText
     * @return array
     */
    public function getReplacements(string $replaceText): array
    {
        return [
            '{-module}'  => strtolower($replaceText),
            '{module}'   => Str::snake(str_replace('-', '_', $replaceText)),
            '{+module}'  => Str::camel($replaceText),
            '{modules}'  => Str::plural(Str::snake(str_replace('-', '_', $replaceText))),
            '{Modules}'  => ucfirst(Str::plural(Str::snake(str_replace('-', '_', $replaceText)))),
            '{-modules}' => Str::plural($replaceText),
            '{MODULE}'   => strtoupper(Str::snake(str_replace('-', '_', $replaceText))),
            '{Module}'   => ucfirst(Str::camel($replaceText)),
        ];
    }
}
