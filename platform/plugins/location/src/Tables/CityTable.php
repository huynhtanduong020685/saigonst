<?php

namespace Botble\Location\Tables;

use Auth;
use Botble\Base\Enums\BaseStatusEnum;
use Botble\Location\Repositories\Interfaces\CityInterface;
use Botble\Location\Repositories\Interfaces\CountryInterface;
use Botble\Location\Repositories\Interfaces\StateInterface;
use Botble\Table\Abstracts\TableAbstract;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Throwable;
use Yajra\DataTables\DataTables;
use Botble\Location\Models\City;

class CityTable extends TableAbstract
{

    /**
     * @var bool
     */
    protected $hasActions = true;

    /**
     * @var bool
     */
    protected $hasFilter = true;

    /**
     * @var CountryInterface
     */
    protected $countryRepository;

    /**
     * @var StateInterface
     */
    protected $stateRepository;

    /**
     * CityTable constructor.
     * @param DataTables $table
     * @param UrlGenerator $urlDevTool
     * @param CityInterface $cityRepository
     * @param CountryInterface $countryRepository
     * @param StateInterface $stateRepository
     */
    public function __construct(
        DataTables $table,
        UrlGenerator $urlDevTool,
        CityInterface $cityRepository,
        CountryInterface $countryRepository,
        StateInterface $stateRepository
    ) {
        $this->repository = $cityRepository;
        $this->countryRepository = $countryRepository;
        $this->stateRepository = $stateRepository;
        $this->setOption('id', 'table-plugins-city');
        parent::__construct($table, $urlDevTool);

        if (!Auth::user()->hasAnyPermission(['city.edit', 'city.destroy'])) {
            $this->hasOperations = false;
            $this->hasActions = false;
        }
    }

    /**
     * Display ajax response.
     *
     * @return JsonResponse
     * @since 2.1
     */
    public function ajax()
    {
        $data = $this->table
            ->eloquent($this->query())
            ->editColumn('name', function ($item) {
                if (!Auth::user()->hasPermission('city.edit')) {
                    return $item->name;
                }
                return anchor_link(route('city.edit', $item->id), $item->name);
            })
            ->editColumn('state_id', function ($item) {
                if (!$item->state_id) {
                    return null;
                }
                return anchor_link(route('state.edit', $item->state_id), $item->state->name);
            })
            ->editColumn('country_id', function ($item) {
                if (!$item->country_id) {
                    return null;
                }
                return anchor_link(route('country.edit', $item->country_id), $item->country->name);
            })
            ->editColumn('checkbox', function ($item) {
                return table_checkbox($item->id);
            })
            ->editColumn('created_at', function ($item) {
                return date_from_database($item->created_at, config('core.base.general.date_format.date'));
            })
            ->editColumn('status', function ($item) {
                return $item->status->toHtml();
            });

        return apply_filters(BASE_FILTER_GET_LIST_DATA, $data, $this->repository->getModel())
            ->addColumn('operations', function ($item) {
                return table_actions('city.edit', 'city.destroy', $item);
            })
            ->escapeColumns([])
            ->make(true);
    }

    /**
     * Get the query object to be processed by table.
     *
     * @return \Illuminate\Database\Query\Builder|Builder
     * @since 2.1
     */
    public function query()
    {
        $model = $this->repository->getModel();
        $query = $model->select([
            'cities.id',
            'cities.name',
            'cities.state_id',
            'cities.country_id',
            'cities.created_at',
            'cities.status',
        ]);

        return $this->applyScopes(apply_filters(BASE_FILTER_TABLE_QUERY, $query, $model));
    }

    /**
     * @return array
     * @since 2.1
     */
    public function columns()
    {
        return [
            'id'         => [
                'name'  => 'cities.id',
                'title' => trans('core/base::tables.id'),
                'width' => '20px',
            ],
            'name'       => [
                'name'  => 'cities.name',
                'title' => trans('core/base::tables.name'),
                'class' => 'text-left',
            ],
            'state_id'   => [
                'name'  => 'cities.state_id',
                'title' => trans('plugins/location::city.state'),
                'class' => 'text-left',
            ],
            'country_id' => [
                'name'  => 'cities.country_id',
                'title' => trans('plugins/location::city.country'),
                'class' => 'text-left',
            ],
            'created_at' => [
                'name'  => 'cities.created_at',
                'title' => trans('core/base::tables.created_at'),
                'width' => '100px',
            ],
            'status'     => [
                'name'  => 'cities.status',
                'title' => trans('core/base::tables.status'),
                'width' => '100px',
            ],
        ];
    }

    /**
     * @return array
     * @throws Throwable
     * @since 2.1
     */
    public function buttons()
    {
        $buttons = $this->addCreateButton(route('city.create'), 'city.create');

        return apply_filters(BASE_FILTER_TABLE_BUTTONS, $buttons, City::class);
    }

    /**
     * @return array
     * @throws Throwable
     */
    public function bulkActions(): array
    {
        return $this->addDeleteAction(route('city.deletes'), 'city.destroy', parent::bulkActions());
    }

    /**
     * @return array
     */
    public function getBulkChanges(): array
    {
        return [
            'cities.name'       => [
                'title'    => trans('core/base::tables.name'),
                'type'     => 'text',
                'validate' => 'required|max:120',
            ],
            'cities.state_id'   => [
                'title'    => trans('plugins/location::city.state'),
                'type'     => 'select',
                'validate' => 'required|max:120',
                'callback' => 'getStates',
            ],
            'cities.country_id' => [
                'title'    => trans('plugins/location::city.country'),
                'type'     => 'select',
                'validate' => 'required|max:120',
                'callback' => 'getCountries',
            ],
            'cities.status'     => [
                'title'    => trans('core/base::tables.status'),
                'type'     => 'select',
                'choices'  => BaseStatusEnum::labels(),
                'validate' => 'required|in:' . implode(',', BaseStatusEnum::values()),
            ],
            'cities.created_at' => [
                'title' => trans('core/base::tables.created_at'),
                'type'  => 'date',
            ],
        ];
    }

    /**
     * @return array
     */
    public function getStates()
    {
        return $this->stateRepository->pluck('states.name', 'states.id');
    }

    /**
     * @return array
     */
    public function getCountries()
    {
        return $this->countryRepository->pluck('countries.name', 'countries.id');
    }
}
