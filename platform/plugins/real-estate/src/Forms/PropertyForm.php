<?php

namespace Botble\RealEstate\Forms;

use Assets;
use Botble\Base\Forms\FormAbstract;
use Botble\Location\Repositories\Interfaces\CityInterface;
use Botble\RealEstate\Enums\PropertyPeriodEnum;
use Botble\RealEstate\Enums\PropertyStatusEnum;
use Botble\RealEstate\Enums\PropertyTypeEnum;
use Botble\RealEstate\Forms\Fields\LocationField;
use Botble\RealEstate\Http\Requests\PropertyRequest;
use Botble\RealEstate\Models\Property;
use Botble\RealEstate\Repositories\Interfaces\CurrencyInterface;
use Botble\RealEstate\Repositories\Interfaces\ProjectInterface;
use Botble\RealEstate\Repositories\Interfaces\FeatureInterface;
use Botble\RealEstate\Repositories\Interfaces\PropertyInterface;
use Botble\RealEstate\Repositories\Interfaces\CategoryInterface;
use Throwable;

class PropertyForm extends FormAbstract
{

    /**
     * @var PropertyInterface $propertyRepository
     */
    protected $propertyRepository;

    /**
     * @var ProjectInterface
     */
    protected $projectRepository;

    /**
     * @var FeatureInterface
     */
    protected $featureRepository;

    /**
     * @var CurrencyInterface
     */
    protected $currencyRepository;

    /**
     * @var CityInterface
     */
    protected $cityRepository;

    /**
     * @var CategoryInterface
     */
    protected $categoryRepository;

    /**
     * ProjectForm constructor.
     * @param PropertyInterface $propertyRepository
     * @param ProjectInterface $projectRepository
     * @param FeatureInterface $featureRepository
     * @param CurrencyInterface $currencyRepository
     * @param CityInterface $cityRepository
     * @param CategoryInterface $categoryRepository
     */
    public function __construct(
        PropertyInterface $propertyRepository,
        ProjectInterface $projectRepository,
        FeatureInterface $featureRepository,
        CurrencyInterface $currencyRepository,
        CityInterface $cityRepository,
        CategoryInterface $categoryRepository
    ) {
        parent::__construct();
        $this->propertyRepository = $propertyRepository;
        $this->projectRepository = $projectRepository;
        $this->featureRepository = $featureRepository;
        $this->currencyRepository = $currencyRepository;
        $this->cityRepository = $cityRepository;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @return mixed|void
     * @throws Throwable
     */
    public function buildForm()
    {
        Assets::addStyles(['datetimepicker'])
            ->addScripts(['input-mask'])
            ->addScriptsDirectly('vendor/core/plugins/real-estate/js/real-estate.js')
            ->addStylesDirectly('vendor/core/plugins/real-estate/css/real-estate.css');

        $projects = $this->projectRepository->pluck('re_projects.name', 're_projects.id');

        $currencies = $this->currencyRepository->pluck('currencies.title', 'currencies.id');
        $cities = $this->cityRepository->pluck('cities.name', 'cities.id');

        $categories = $this->categoryRepository->pluck('re_categories.name', 're_categories.id');

        $selectedFeatures = [];
        if ($this->getModel()) {
            $selectedFeatures = $this->getModel()->features()->pluck('re_features.id')->all();
        }

        $features = $this->featureRepository->allBy([], [], ['re_features.id', 're_features.name']);

        $this
            ->setupModel(new Property)
            ->setValidatorClass(PropertyRequest::class)
            ->withCustomFields()
            ->addCustomField('location', LocationField::class)
            ->add('name', 'text', [
                'label'      => trans('plugins/real-estate::property.form.name'),
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'placeholder'  => trans('plugins/real-estate::property.form.name'),
                    'data-counter' => 120,
                ],
            ])
            ->add('type', 'customSelect', [
                'label'      => trans('plugins/real-estate::property.form.type'),
                'label_attr' => ['class' => 'control-label required'],
                'choices'    => PropertyTypeEnum::labels(),
            ])
            ->add('is_featured', 'onOff', [
                'label'         => trans('core/base::forms.is_featured'),
                'label_attr'    => ['class' => 'control-label'],
                'default_value' => false,
            ])
            ->add('description', 'textarea', [
                'label'      => trans('core/base::forms.description'),
                'label_attr' => ['class' => 'control-label'],
                'attr'       => [
                    'rows'         => 4,
                    'placeholder'  => trans('core/base::forms.description_placeholder'),
                    'data-counter' => 400,
                ],
            ])
            ->add('content', 'editor', [
                'label'      => trans('core/base::forms.content'),
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'rows' => 4,
                ],
            ])
            ->add('city_id', 'customSelect', [
                'label'      => trans('plugins/real-estate::property.form.city'),
                'label_attr' => ['class' => 'control-label'],
                'attr'       => [
                    'class' => 'form-control select-search-full',
                ],
                'choices'    => $cities,
            ])
            ->add('location', 'location', [
                'label'      => trans('plugins/real-estate::property.form.location'),
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'placeholder'  => trans('plugins/real-estate::property.form.location'),
                    'data-counter' => 300,
                ],
            ])
            ->add('rowOpen1', 'html', [
                'html' => '<div class="row">',
            ])
            ->add('number_bedroom', 'number', [
                'label'      => trans('plugins/real-estate::property.form.number_bedroom'),
                'label_attr' => ['class' => 'control-label'],
                'wrapper'    => [
                    'class' => 'form-group col-md-3',
                ],
                'attr'       => [
                    'placeholder' => trans('plugins/real-estate::property.form.number_bedroom'),
                ],
            ])
            ->add('number_bathroom', 'number', [
                'label'      => trans('plugins/real-estate::property.form.number_bathroom'),
                'label_attr' => ['class' => 'control-label'],
                'wrapper'    => [
                    'class' => 'form-group col-md-3',
                ],
                'attr'       => [
                    'placeholder' => trans('plugins/real-estate::property.form.number_bathroom'),
                ],
            ])
            ->add('number_floor', 'number', [
                'label'      => trans('plugins/real-estate::property.form.number_floor'),
                'label_attr' => ['class' => 'control-label'],
                'wrapper'    => [
                    'class' => 'form-group col-md-3',
                ],
                'attr'       => [
                    'placeholder' => trans('plugins/real-estate::property.form.number_floor'),
                ],
            ])
            ->add('square', 'number', [
                'label'      => trans('plugins/real-estate::property.form.square'),
                'label_attr' => ['class' => 'control-label'],
                'wrapper'    => [
                    'class' => 'form-group col-md-3',
                ],
                'attr'       => [
                    'placeholder' => trans('plugins/real-estate::property.form.square'),
                ],
            ])
            ->add('rowClose1', 'html', [
                'html' => '</div>',
            ])
            ->add('rowOpen2', 'html', [
                'html' => '<div class="row">',
            ])
            ->add('price', 'text', [
                'label'      => trans('plugins/real-estate::property.form.price'),
                'label_attr' => ['class' => 'control-label'],
                'wrapper'    => [
                    'class' => 'form-group col-md-4',
                ],
                'attr'       => [
                    'id'          => 'price-number',
                    'placeholder' => trans('plugins/real-estate::property.form.price'),
                    'class'       => 'form-control input-mask-number',
                ],
            ])
            ->add('currency_id', 'customSelect', [
                'label'      => trans('plugins/real-estate::project.form.currency'),
                'label_attr' => ['class' => 'control-label'],
                'wrapper'    => [
                    'class' => 'form-group col-md-4',
                ],
                'attr'       => [
                    'class' => 'form-control select-full',
                ],
                'choices'    => $currencies,
            ])
            ->add('period', 'customSelect', [
                'label'      => trans('plugins/real-estate::property.form.period'),
                'label_attr' => ['class' => 'control-label required'],
                'wrapper'    => [
                    'class' => 'form-group col-md-4' . ($this->getModel()->type == PropertyTypeEnum::SALE ? ' hidden' : null),
                ],
                'attr'       => [
                    'class' => 'form-control select-search-full',
                ],
                'choices'    => PropertyPeriodEnum::labels(),
            ])
            ->add('rowClose2', 'html', [
                'html' => '</div>',
            ])
            ->addMetaBoxes([
                'image'    => [
                    'title'    => trans('plugins/real-estate::property.form.images'),
                    'content'  => view('plugins/real-estate::partials.form-images',
                        ['object' => $this->getModel()])->render(),
                    'priority' => 0,
                ],
                'features' => [
                    'title'    => trans('plugins/real-estate::property.form.features'),
                    'content'  => view('plugins/real-estate::partials.form-features',
                        compact('selectedFeatures', 'features'))->render(),
                    'priority' => 1,
                ],
            ])
            ->add('status', 'customSelect', [
                'label'      => trans('core/base::tables.status'),
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'class' => 'form-control select-search-full',
                ],
                'choices'    => PropertyStatusEnum::labels(),
            ])
            ->add('category_id', 'customSelect', [
                'label'      => trans('plugins/real-estate::property.form.category'),
                'label_attr' => ['class' => 'control-label'],
                'attr'       => [
                    'class' => 'form-control select-search-full',
                ],
                'choices'    => $categories,
            ])
            ->add('project_id', 'customSelect', [
                'label'      => trans('plugins/real-estate::property.form.project'),
                'label_attr' => ['class' => 'control-label'],
                'choices'    => [0 => __('Select a project...')] + $projects,
            ])
            ->setBreakFieldPoint('status');

        if (is_plugin_active('vendor')) {
            $this->add('author_id', 'autocomplete', [
                'label'      => __('Vendor'),
                'label_attr' => [
                    'class' => 'control-label',
                ],
                'attr'       => [
                    'id'       => 'author_id',
                    'data-url' => route('vendor.list'),
                ],
                'choices'    => $this->getModel()->author_id ?
                    [
                        $this->model->author->id => $this->model->author->getFullName(),
                    ]
                    :
                    ['' => __('Select vendor...')],
            ]);
        }
    }
}
