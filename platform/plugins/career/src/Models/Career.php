<?php

namespace Botble\Career\Models;

use Botble\Base\Traits\EnumCastable;
use Botble\Base\Enums\BaseStatusEnum;
use Botble\Slug\Traits\SlugTrait;
use Eloquent;

/**
 * Botble\Career\Models\Career
 *
 * @mixin \Eloquent
 */
class Career extends Eloquent
{
    use EnumCastable;
    use SlugTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'careers';

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'location',
        'salary',
        'description',
        'status',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'status' => BaseStatusEnum::class,
    ];
}
