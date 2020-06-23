<?php

namespace Botble\Vendor\Forms;

use Assets;
use Botble\Base\Forms\FormAbstract;
use Botble\Base\Enums\BaseStatusEnum;
use Botble\RealEstate\Repositories\Interfaces\CurrencyInterface;
use Botble\Vendor\Http\Requests\PackageRequest;
use Botble\Vendor\Models\Package;

class PackageForm extends FormAbstract
{
    /**
     * @var CurrencyInterface
     */
    protected $currencyRepository;

    /**
     * PackageForm constructor.
     * @param CurrencyInterface $currencyRepository
     */
    public function __construct(CurrencyInterface $currencyRepository)
    {
        parent::__construct();
        $this->currencyRepository = $currencyRepository;
    }

    /**
     * @return mixed|void
     * @throws \Throwable
     */
    public function buildForm()
    {

        Assets::addScripts(['input-mask']);

        $currencies = $this->currencyRepository->pluck('currencies.title', 'currencies.id');

        $this
            ->setupModel(new Package)
            ->setValidatorClass(PackageRequest::class)
            ->withCustomFields()
            ->add('name', 'text', [
                'label'      => trans('core/base::forms.name'),
                'label_attr' => ['class' => 'control-label required'],
                'wrapper'    => [
                    'class' => 'form-group col-md-12',
                ],
                'attr'       => [
                    'placeholder'  => trans('core/base::forms.name_placeholder'),
                    'data-counter' => 120,
                ],
            ])
            ->add('price', 'text', [
                'label'      => trans('plugins/vendor::package.price'),
                'label_attr' => ['class' => 'control-label'],
                'wrapper'    => [
                    'class' => 'form-group float-left col-md-6',
                ],
                'attr'       => [
                    'id'          => 'price-number',
                    'placeholder' => trans('plugins/vendor::package.price'),
                    'class'       => 'form-control input-mask-number',
                ],
            ])
            ->add('currency_id', 'customSelect', [
                'label'      => trans('plugins/vendor::package.currency'),
                'label_attr' => ['class' => 'control-label'],
                'wrapper'    => [
                    'class' => 'form-group float-left col-md-6',
                ],
                'attr'       => [
                    'class' => 'form-control select-full',
                ],
                'choices'    => $currencies,
            ])
            ->add('number_of_days', 'text', [
                'label'      => trans('plugins/vendor::package.number_of_days'),
                'label_attr' => ['class' => 'control-label'],
                'wrapper'    => [
                    'class' => 'form-group float-left col-md-6',
                ],
                'attr'       => [
                    'id'          => 'price-number',
                    'placeholder' => trans('plugins/vendor::package.number_of_days'),
                    'class'       => 'form-control input-mask-number',
                ],
            ])
            ->add('number_of_listings', 'text', [
                'label'      => trans('plugins/vendor::package.number_of_listings'),
                'label_attr' => ['class' => 'control-label'],
                'wrapper'    => [
                    'class' => 'form-group float-left col-md-6',
                ],
                'attr'       => [
                    'id'          => 'price-number',
                    'placeholder' => trans('plugins/vendor::package.number_of_listings'),
                    'class'       => 'form-control input-mask-number',
                ],
            ])
            ->add('is_default', 'onOff', [
                'label'         => trans('core/base::forms.is_default'),
                'label_attr'    => ['class' => 'control-label'],
                'wrapper'    => [
                    'class' => 'form-group float-left col-md-12',
                ],
                'default_value' => false,
            ])
            ->add('order', 'number', [
                'label'         => trans('core/base::forms.order'),
                'label_attr'    => ['class' => 'control-label'],
                'wrapper'    => [
                    'class' => 'form-group float-left col-md-12',
                ],
                'attr'          => [
                    'placeholder' => trans('core/base::forms.order_by_placeholder'),
                ],
                'default_value' => 0,
            ])
            ->add('status', 'customSelect', [
                'label'      => trans('core/base::tables.status'),
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'class' => 'form-control select-full',
                ],
                'choices'    => BaseStatusEnum::labels(),
            ])
            ->setBreakFieldPoint('status');
    }
}
