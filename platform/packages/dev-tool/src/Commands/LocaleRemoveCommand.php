<?php

namespace Botble\DevTool\Commands;

use File;
use Illuminate\Console\Command;
use Illuminate\Console\ConfirmableTrait;

class LocaleRemoveCommand extends Command
{
    use ConfirmableTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cms:locale:remove {locale : The locale to remove}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove a locale';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (!$this->confirmToProceed('Are you sure you want to permanently delete?', true)) {
            return false;
        }

        if (!preg_match('/^[a-z0-9\-]+$/i', $this->argument('locale'))) {
            $this->error('Only alphabetic characters are allowed.');
            return false;
        }

        $defaultLocale = resource_path('lang/' . $this->argument('locale'));
        if (File::exists($defaultLocale)) {
            File::deleteDirectory($defaultLocale);
            $this->info('Deleted: ' . $defaultLocale);
        }

        $this->removeLocaleInPath(resource_path('lang/vendor/core'));
        $this->removeLocaleInPath(resource_path('lang/vendor/packages'));
        $this->removeLocaleInPath(resource_path('lang/vendor/plugins'));
    }

    /**
     * @param string $path
     * @return int|void
     */
    protected function removeLocaleInPath(string $path)
    {
        $folders = File::directories($path);

        foreach ($folders as $module) {
            foreach (File::directories($module) as $locale) {
                if (File::name($locale) == $this->argument('locale')) {
                    File::deleteDirectory($locale);
                    $this->info('Deleted: ' . $locale);
                }
            }
        }

        return count($folders);
    }
}
