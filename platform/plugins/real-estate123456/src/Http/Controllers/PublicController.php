<?php

namespace Botble\RealEstate\Http\Controllers;

use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Base\Supports\EmailHandler;
use Botble\RealEstate\Http\Requests\ConsultRequest;
use Botble\RealEstate\Models\Consult;
use Botble\RealEstate\Repositories\Interfaces\ConsultInterface;
use Botble\Setting\Supports\SettingStore;
use Exception;
use Illuminate\Routing\Controller;
use MailVariable;
use Throwable;

class PublicController extends Controller
{
    /**
     * @var ConsultInterface
     */
    protected $consultRepository;

    /**
     * @param ConsultInterface $consultRepository
     */
    public function __construct(ConsultInterface $consultRepository)
    {
        $this->consultRepository = $consultRepository;
    }

    /**
     * @param ConsultRequest $request
     * @param BaseHttpResponse $response
     * @param SettingStore $setting
     * @param EmailHandler $emailHandler
     * @return BaseHttpResponse
     * @throws Throwable
     */
    public function postSendConsult(
        ConsultRequest $request,
        BaseHttpResponse $response,
        SettingStore $setting,
        EmailHandler $emailHandler
    ) {
        try {
            /**
             * @var Consult $consult
             */
            $consult = $this->consultRepository->getModel();

            if ($request->input('type') == 'project') {
                $request->merge(['project_id' => $request->input('data_id')]);
            } else {
                $request->merge(['property_id' => $request->input('data_id')]);
            }

            $consult->fill($request->input());
            $this->consultRepository->createOrUpdate($consult);

            if ($setting->get('plugins_consult_notice_status', true)) {
                MailVariable::setModule(CONSULT_MODULE_SCREEN_NAME)
                    ->setVariableValues([
                        'consult_name'    => $consult->name ?? 'N/A',
                        'consult_email'   => $consult->email ?? 'N/A',
                        'consult_phone'   => $consult->phone ?? 'N/A',
                        'consult_content' => $consult->content ?? 'N/A',
                    ]);

                $content = get_setting_email_template_content('plugins', 'consult', 'notice');

                $emailHandler->send($content, $setting->get('plugins_consult_notice_subject',
                    config('plugins.real-estate.email.templates.notice.subject')));
            }

            return $response->setMessage(trans('plugins/real-estate::consult.email.success'));
        } catch (Exception $ex) {
            info($ex->getMessage());
            return $response
                ->setError()
                ->setMessage(trans('plugins/real-estate::consult.email.failed'));
        }
    }
}
