<?php

namespace Botble\Installer\Helpers;

use Botble\Base\Supports\Helper;
use Exception;
use Illuminate\Database\SQLiteConnection;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Output\BufferedOutput;

class DatabaseManager
{
    /**
     * Migrate and seed the database.
     *
     * @return array
     */
    public function migrateAndSeed()
    {
        $outputLog = new BufferedOutput;

        $this->sqlite($outputLog);

        return $this->migrate($outputLog);
    }

    /**
     * Check database type. If SQLite, then create the database file.
     *
     * @param BufferedOutput $outputLog
     */
    protected function sqlite(BufferedOutput $outputLog)
    {
        if (DB::connection() instanceof SQLiteConnection) {
            $database = DB::connection()->getDatabaseName();
            if (!file_exists($database)) {
                touch($database);
                DB::reconnect(Config::get('database.default'));
            }
            $outputLog->write('Using SqlLite database: ' . $database, 1);
        }
    }

    /**
     * Run the migration and call the seeder.
     *
     * @param BufferedOutput $outputLog
     * @return array
     */
    protected function migrate(BufferedOutput $outputLog)
    {
        // try {
            Helper::executeCommand('migrate:fresh', ['--force' => true], $outputLog);
            return $this->response(trans('packages/installer::installer.final.finished'), $outputLog, 'success');
        // } catch (Exception $exception) {
        //    return $this->response($exception->getMessage(), $outputLog, 'error');
        //}
    }

    /**
     * Return a formatted error messages.
     *
     * @param string $message
     * @param string $status
     * @param BufferedOutput $outputLog
     * @return array
     */
    protected function response($message, BufferedOutput $outputLog, $status = 'danger')
    {
        return [
            'status'      => $status,
            'message'     => $message,
            'dbOutputLog' => $outputLog->fetch(),
        ];
    }
}
