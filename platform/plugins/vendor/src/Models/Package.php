<?php

namespace Botble\Vendor\Models;

use Botble\Base\Traits\EnumCastable;
use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Models\BaseModel;
use Botble\RealEstate\Models\Currency;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Package extends BaseModel
{
    use EnumCastable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'packages';

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'price',
        'currency_id',
        'number_of_days',
        'number_of_listings',
        'order',
        'is_default',
        'status',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'status' => BaseStatusEnum::class,
    ];

    /**
     * @return BelongsTo
     */
    public function currency()
    {
        return $this->belongsTo(Currency::class)->withDefault();
    }
}
