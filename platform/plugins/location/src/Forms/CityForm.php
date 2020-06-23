<?php

namespace Botble\Location\Forms;

use Botble\Base\Forms\FormAbstract;
use Botble\Base\Enums\BaseStatusEnum;
use Botble\Location\Http\Requests\CityRequest;
use Botble\Location\Models\City;
use Botble\Location\Repositories\Interfaces\CountryInterface;
use Botble\Location\Repositories\Interfaces\StateInterface;
use Throwable;

class CityForm extends FormAbstract
{

    /**
     * @var CountryInterface
     */
    protected $countryRepository;

    /**
     * @var StateInterface
     */
    protected $stateRepository;

    /**
     * StateForm constructor.
     * @param CountryInterface $countryRepository
     * @param StateInterface $stateRepository
     */
    public function __construct(CountryInterface $countryRepository, StateInterface $stateRepository)
    {
        parent::__construct();

        $this->countryRepository = $countryRepository;
        $this->stateRepository = $stateRepository;
    }

    /**
     * @return mixed|void
     * @throws Throwable
     */
    public function buildForm()
    {
        $countries = $this->countryRepository->pluck('countries.name', 'countries.id');
        $states = $this->stateRepository->pluck('states.name', 'states.id');

        $this
            ->setupModel(new City)
            ->setValidatorClass(CityRequest::class)
            ->withCustomFields()
            ->add('name', 'text', [
                'label'      => trans('core/base::forms.name'),
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'placeholder'  => trans('core/base::forms.name_placeholder'),
                    'data-counter' => 120,
                ],
            ])
            ->add('slug', 'text', [
                'label'      => trans('plugins/location::city.state'),
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'placeholder'  => trans('plugins/location::city.state'),
                    'data-counter' => 120,
                ],
            ])
            ->add('state_id', 'customSelect', [
                'label'      => trans('plugins/location::city.state'),
                'label_attr' => ['class' => 'control-label'],
                'attr'       => [
                    'class' => 'form-control select-search-full',
                ],
                'choices'    => [0 => trans('plugins/location::city.select_state')] + $states,
            ])
            ->add('country_id', 'customSelect', [
                'label'      => trans('plugins/location::city.country'),
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'class' => 'form-control select-search-full',
                ],
                'choices'    => [0 => trans('plugins/location::city.select_country')] + $countries,
            ])
            ->add('is_featured', 'onOff', [
                'label'         => trans('core/base::forms.is_featured'),
                'label_attr'    => ['class' => 'control-label'],
                'default_value' => false,
            ])
            ->add('order', 'number', [
                'label'         => trans('core/base::forms.order'),
                'label_attr'    => ['class' => 'control-label'],
                'attr'          => [
                    'placeholder' => trans('core/base::forms.order_by_placeholder'),
                ],
                'default_value' => 0,
            ])
            ->add('is_default', 'onOff', [
                'label'         => trans('core/base::forms.is_default'),
                'label_attr'    => ['class' => 'control-label'],
                'default_value' => false,
            ])
            ->add('status', 'customSelect', [
                'label'      => trans('core/base::tables.status'),
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'class' => 'form-control select-full',
                ],
                'choices'    => BaseStatusEnum::labels(),
            ])
            ->add('image', 'mediaImage', [
                'label'      => trans('core/base::forms.image'),
                'label_attr' => ['class' => 'control-label'],
            ])
            ->setBreakFieldPoint('status');
    }
}
