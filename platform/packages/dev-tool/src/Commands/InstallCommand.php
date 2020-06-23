<?php

namespace Botble\DevTool\Commands;

use Botble\Base\Supports\Core;
use Illuminate\Console\Command;
use Illuminate\Console\ConfirmableTrait;
use Illuminate\Database\QueryException;

class InstallCommand extends Command
{

    use ConfirmableTrait;

    /**
     * The console command signature.
     *
     * @var string
     */
    protected $signature = 'cms:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install CMS';

    /**
     * @var UserCreateCommand
     */
    protected $userCreateCommand;

    /**
     * @var Core
     */
    protected $coreApi;

    /**
     * InstallCommand constructor.
     * @param UserCreateCommand $userCreateCommand
     * @param Core $coreApi
     */
    public function __construct(UserCreateCommand $userCreateCommand, Core $coreApi)
    {
        parent::__construct();
        $this->userCreateCommand = $userCreateCommand;
        $this->coreApi = $coreApi;
    }

    /**
     * Execute the console command.
     *
     * @return bool
     */
    public function handle()
    {
        $this->info('Starting installation...');

        $result = $this->coreApi->verifyLicense();

        if (!$result['status']) {
            $this->info('Please verify your license first!');
            $purchaseCode = $this->ask('Enter your license code (It is the Purchase code if you\'ve purchased this product from Codecanyon)');
            $buyer = $this->ask('Enter your name (It is your Envato\'s username if you\'ve purchased this product from Codecanyon)');

            $result = $this->coreApi->activateLicense($purchaseCode, $buyer);

            if (!$result['status']) {
                $this->error($result['message']);
                return false;
            }

            $this->info($result['message']);
        }

        try {
            $this->call('migrate:fresh');
        } catch (QueryException $exception) {
            $this->call('migrate:fresh');
        }

        if ($this->confirmToProceed('Do you want to add a new admin user?', true)) {
            $this->call($this->userCreateCommand->getName());
        }

        $this->info('Publish vendor assets');
        $this->call('vendor:publish', ['--tag' => 'cms-public']);

        $this->info('Creating a symbolic link from "public/storage" to "storage/app/public"');
        $this->call('storage:link');

        $this->info('Installed Botble CMS successfully!');

        return true;
    }
}
