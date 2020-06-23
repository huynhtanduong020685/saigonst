<?php

namespace Botble\RealEstate\Enums;

use Botble\Base\Supports\Enum;
use Html;

/**
 * @method static PropertyTypeEnum SALE()
 * @method static PropertyTypeEnum RENT()
 */
class PropertyTypeEnum extends Enum
{
    public const SALE = 'sale';
    public const RENT = 'rent';

    /**
     * @var string
     */
    public static $langPath = 'plugins/real-estate::property.types';

    /**
     * @return string
     */
     public function toHtml()
    {
        switch ($this->value) {
            case self::DRAFT:
                return Html::tag('span', self::DRAFT()->label(), ['class' => 'label-info status-label'])
                    ->toHtml();
            case self::PENDING:
                return Html::tag('span', self::PENDING()->label(), ['class' => 'label-warning status-label'])
                    ->toHtml();
            case self::PUBLISHED:
                return Html::tag('span', self::PUBLISHED()->label(), ['class' => 'label-success status-label'])
                    ->toHtml();
            default:
                return null;
        }
    }
}
