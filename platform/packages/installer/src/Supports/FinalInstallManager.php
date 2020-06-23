<?php

namespace Botble\Installer\Helpers;

use Botble\Base\Supports\Helper;
use Exception;
use Symfony\Component\Console\Output\BufferedOutput;

class FinalInstallManager
{
    /**
     * Run final commands.
     *
     * @return string
     */
    public function runFinal()
    {
        $outputLog = new BufferedOutput;

        $this->generateKey($outputLog);
        $this->publishVendorAssets($outputLog);

        return $outputLog->fetch();
    }

    /**
     * Generate New Application Key.
     *
     * @param BufferedOutput $outputLog
     * @return BufferedOutput|array
     */
    protected static function generateKey(BufferedOutput $outputLog)
    {
        try {
            Helper::executeCommand('key:generate', ['--force' => true], $outputLog);
        } catch (Exception $e) {
            return static::response($e->getMessage(), $outputLog);
        }

        return $outputLog;
    }

    /**
     * Return a formatted error messages.
     *
     * @param $message
     * @param BufferedOutput $outputLog
     * @return array
     */
    protected static function response($message, BufferedOutput $outputLog)
    {
        return [
            'status'      => 'error',
            'message'     => $message,
            'dbOutputLog' => $outputLog->fetch(),
        ];
    }

    /**
     * Publish vendor assets.
     *
     * @param BufferedOutput $outputLog
     * @return BufferedOutput|array
     */
    protected static function publishVendorAssets(BufferedOutput $outputLog)
    {
        try {
            Helper::executeCommand('vendor:publish', ['--tag' => 'cms-public', '--force' => true], $outputLog);
        } catch (Exception $e) {
            return static::response($e->getMessage(), $outputLog);
        }

        return $outputLog;
    }
}
