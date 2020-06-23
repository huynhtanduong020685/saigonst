<?php

namespace Botble\Installer\Http\Controllers;

use Botble\ACL\Models\User;
use Botble\ACL\Repositories\Interfaces\UserInterface;
use Botble\ACL\Services\ActivateUserService;
use Botble\Base\Supports\Helper;
use Botble\Installer\Events\EnvironmentSaved;
use Botble\Installer\Events\InstallerFinished;
use Botble\Installer\Helpers\DatabaseManager;
use Botble\Installer\Helpers\EnvironmentManager;
use Botble\Installer\Helpers\FinalInstallManager;
use Botble\Installer\Helpers\PermissionsChecker;
use Botble\Installer\Helpers\RequirementsChecker;
use Botble\Installer\Http\Requests\SaveAccountRequest;
use Botble\Installer\Http\Requests\SaveEnvironmentRequest;
use Botble\Setting\Supports\SettingStore;
use DB;
use Exception;
use File;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\MessageBag;
use Illuminate\View\View;
use URL;

class InstallController extends Controller
{
    /**
     * @var RequirementsChecker
     */
    protected $requirements;

    /**
     * @var PermissionsChecker
     */
    protected $permissions;

    /**
     * @var EnvironmentManager
     */
    protected $environmentManager;

    /**
     * @var DatabaseManager
     */
    protected $databaseManager;

    /**
     * @var UserInterface
     */
    protected $userRepository;

    /**
     * @param RequirementsChecker $requirementsChecker
     * @param PermissionsChecker $permissionsChecker
     * @param EnvironmentManager $environmentManager
     * @param DatabaseManager $databaseManager
     * @param UserInterface $userRepository
     */
    public function __construct(
        RequirementsChecker $requirementsChecker,
        PermissionsChecker $permissionsChecker,
        EnvironmentManager $environmentManager,
        DatabaseManager $databaseManager,
        UserInterface $userRepository
    ) {
        $this->requirements = $requirementsChecker;
        $this->permissions = $permissionsChecker;
        $this->environmentManager = $environmentManager;
        $this->databaseManager = $databaseManager;
        $this->userRepository = $userRepository;
    }

    /**
     * Display the installer welcome page.
     *
     * @return Factory|View
     */
    public function getWelcome()
    {
        return view('packages/installer::welcome');
    }

    /**
     * Display the requirements page.
     *
     * @param Request $request
     * @return View
     */
    public function getRequirements(Request $request)
    {
        if (!URL::hasValidSignature($request)) {
            abort(404);
        }

        $phpSupportInfo = $this->requirements->checkPhpVersion(config('packages.installer.installer.core.php_version'));
        $requirements = $this->requirements->check(config('packages.installer.installer.requirements'));

        return view('packages/installer::.requirements', compact('requirements', 'phpSupportInfo'));
    }

    /**
     * Display the Environment page.
     *
     * @param Request $request
     * @return View
     */
    public function getEnvironment(Request $request)
    {
        if (!URL::hasValidSignature($request)) {
            abort(404);
        }

        return view('packages/installer::environment');
    }

    /**
     * Processes the newly saved environment configuration (Form Wizard).
     *
     * @param SaveEnvironmentRequest $request
     * @param SettingStore $settingStore
     * @return Factory|RedirectResponse|View
     */
    public function postSaveEnvironment(SaveEnvironmentRequest $request)
    {
        $connectionName = 'database.connections.' . $request->input('database_connection');

        config([
            'database.default' => $request->input('database_connection'),
            $connectionName    => array_merge(config($connectionName), [
                'host'     => $request->input('database_hostname'),
                'port'     => $request->input('database_port'),
                'database' => $request->input('database_name'),
                'username' => $request->input('database_username'),
                'password' => $request->input('database_password'),
            ]),
        ]);

        DB::purge($request->input('database_connection'));

        if (!Helper::isConnectedDatabase()) {
            $errors = new MessageBag;
            $errors->add('database_name', __('Wrong database config'));

            return view('packages/installer::environment', compact('errors'));
        }

        $results = $this->environmentManager->save($request);

        event(new EnvironmentSaved($request));

        save_file_data(storage_path(INSTALLING_SESSION_NAME), now()->toDateTimeString());

        return redirect()
            ->to(URL::signedRoute('installers.create_account', [], now()->addMinutes(30)))
            ->with('install_message', $results);
    }

    /**
     * @return Factory|View
     */
    public function getCreateAccount(Request $request)
    {
        /*if (!URL::hasValidSignature($request)) {
            abort(404);
        }*/

        $this->databaseManager->migrateAndSeed();

        return view('packages/installer::account');
    }

    /**
     * @param SaveAccountRequest $request
     * @param ActivateUserService $activateUserService
     * @return RedirectResponse
     */
    public function postSaveAccount(SaveAccountRequest $request, ActivateUserService $activateUserService)
    {
        $request->merge([
            'super_user'           => 1,
            ACL_ROLE_MANAGE_SUPERS => 1,
            'profile_image'        => config('core.acl.general.avatar.default'),
            'password'             => bcrypt($request->input('password')),
        ]);

        try {
            /**
             * @var User $user
             */
            $user = $this->userRepository->createOrUpdate($request->input());
            if (!empty($user) && $activateUserService->activate($user)) {
                info('Super user is created.');
            }
        } catch (Exception $exception) {
            info('User could not be created: ' . $exception->getMessage());
        }

        return redirect()
            ->to(URL::signedRoute('installers.final', [], now()->addMinutes(30)));
    }

    /**
     * Update installed file and display finished view.
     *
     * @param FinalInstallManager $finalInstall
     * @param Request $request
     * @return Factory|View
     */
    public function getFinish(FinalInstallManager $finalInstall, Request $request)
    {
        if (!URL::hasValidSignature($request)) {
            abort(404);
        }

        $finalInstall->runFinal();

        event(new InstallerFinished);

        File::delete(storage_path(INSTALLING_SESSION_NAME));

        return view('packages/installer::finished');
    }
}
