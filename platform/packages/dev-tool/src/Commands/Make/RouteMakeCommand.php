<?php

namespace Botble\DevTool\Commands\Make;

use Botble\DevTool\Commands\Abstracts\BaseMakeCommand;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Filesystem\Filesystem;

class RouteMakeCommand extends BaseMakeCommand
{
    /**
     * The filesystem instance.
     *
     * @var Filesystem
     */
    protected $files;

    /**
     * The console command signature.
     *
     * @var string
     */
    protected $signature = 'cms:make:route {name : The table that you want to create} {module : module name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make a route';

    /**
     * Create a new key generator command.
     *
     * @param Filesystem $files
     *
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }

    /**
     * Execute the console command.
     *
     * @throws \League\Flysystem\FileNotFoundException
     * @throws FileNotFoundException
     */
    public function handle()
    {
        if (!preg_match('/^[a-z0-9\-\_]+$/i', $this->argument('name'))) {
            $this->error('Only alphabetic characters are allowed.');
            return false;
        }

        $name = $this->argument('name');
        $path = package_path(strtolower($this->argument('module')) . '/routes/' . strtolower($name) . '.php');

        $this->publishStubs($this->getStub(), $path);
        $this->renameFiles($name, $path);
        $this->searchAndReplaceInFiles($name, $path);
        $this->line('------------------');

        $this->info('Create successfully!');

        return true;
    }

    /**
     * @return string
     */
    public function getStub(): string
    {
        return __DIR__ . '/../../../stubs/module/routes/web.stub';
    }

    /**
     * @param string $replaceText
     * @return array
     */
    public function getReplacements(string $replaceText): array
    {
        return [];
    }
}
