<?php

namespace Botble\Location\Tables;

use Auth;
use Botble\Base\Enums\BaseStatusEnum;
use Botble\Location\Repositories\Interfaces\CountryInterface;
use Botble\Table\Abstracts\TableAbstract;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Throwable;
use Yajra\DataTables\DataTables;
use Botble\Location\Models\Country;

class CountryTable extends TableAbstract
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
     * CountryTable constructor.
     * @param DataTables $table
     * @param UrlGenerator $urlDevTool
     * @param CountryInterface $countryRepository
     */
    public function __construct(DataTables $table, UrlGenerator $urlDevTool, CountryInterface $countryRepository)
    {
        $this->repository = $countryRepository;
        $this->setOption('id', 'table-plugins-country');
        parent::__construct($table, $urlDevTool);

        if (!Auth::user()->hasAnyPermission(['country.edit', 'country.destroy'])) {
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
                if (!Auth::user()->hasPermission('country.edit')) {
                    return $item->name;
                }
                return anchor_link(route('country.edit', $item->id), $item->name);
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
                return table_actions('country.edit', 'country.destroy', $item);
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
            'countries.id',
            'countries.name',
            'countries.nationality',
            'countries.created_at',
            'countries.status',
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
            'id'          => [
                'name'  => 'countries.id',
                'title' => trans('core/base::tables.id'),
                'width' => '20px',
            ],
            'name'        => [
                'name'  => 'countries.name',
                'title' => trans('core/base::tables.name'),
                'class' => 'text-left',
            ],
            'nationality' => [
                'name'  => 'countries.nationality',
                'title' => trans('plugins/location::country.nationality'),
                'class' => 'text-left',
            ],
            'created_at'  => [
                'name'  => 'countries.created_at',
                'title' => trans('core/base::tables.created_at'),
                'width' => '100px',
            ],
            'status'      => [
                'name'  => 'countries.status',
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
        $buttons = $this->addCreateButton(route('country.create'), 'country.create');

        return apply_filters(BASE_FILTER_TABLE_BUTTONS, $buttons, Country::class);
    }

    /**
     * @return array
     * @throws Throwable
     */
    public function bulkActions(): array
    {
        return $this->addDeleteAction(route('country.deletes'), 'country.destroy', parent::bulkActions());
    }

    /**
     * @return array
     */
    public function getBulkChanges(): array
    {
        return [
            'countries.name'        => [
                'title'    => trans('core/base::tables.name'),
                'type'     => 'text',
                'validate' => 'required|max:120',
            ],
            'countries.nationality' => [
                'title'    => trans('plugins/location::country.nationality'),
                'type'     => 'text',
                'validate' => 'required|max:120',
            ],
            'countries.status'      => [
                'title'    => trans('core/base::tables.status'),
                'type'     => 'select',
                'choices'  => BaseStatusEnum::labels(),
                'validate' => 'required|in:' . implode(',', BaseStatusEnum::values()),
            ],
            'countries.created_at'  => [
                'title' => trans('core/base::tables.created_at'),
                'type'  => 'date',
            ],
        ];
    }
}
