<?php

use Botble\RealEstate\Enums\PropertyPeriodEnum;
use Botble\RealEstate\Enums\PropertyStatusEnum;
use Botble\RealEstate\Enums\PropertyTypeEnum;

return [
    'name'     => 'Properties',
    'create'   => 'New real property',
    'edit'     => 'Edit real property',
    'form'     => [
        'main_info'        => 'General information',
        'basic_info'       => 'Basic information',
        'name'             => 'Title',
        'type'             => 'Type',
        'images'           => 'Images',
        'button_add_image' => 'Add images',
        'location'         => 'Property location',
        'number_bedroom'   => 'Number bedrooms',
        'number_bathroom'  => 'Number bathrooms',
        'number_floor'     => 'Number floors',
        'square'           => 'Square (m2)',
        'price'            => 'Price',
        'features'         => 'Features',
        'project'          => 'Project',
        'date'             => 'Date information',
        'currency'         => 'Currency',
        'city'             => 'City',
        'period'           => 'Period',
        'category'    => 'Category',
    ],
    'statuses' => [
        PropertyStatusEnum::NOT_AVAILABLE => 'Not available',
        PropertyStatusEnum::PRE_SALE      => 'Preparing selling',
        PropertyStatusEnum::SELLING       => 'Selling',
        PropertyStatusEnum::SOLD          => 'Sold',
        PropertyStatusEnum::RENTING       => 'Renting',
        PropertyStatusEnum::RENTED        => 'Rented',
        PropertyStatusEnum::BUILDING      => 'Building',
    ],
    'types'    => [
        PropertyTypeEnum::SALE => 'Sale',
        PropertyTypeEnum::RENT => 'Rent',
    ],
    'periods'  => [
        PropertyPeriodEnum::DAY   => 'Day',
        PropertyPeriodEnum::MONTH => 'Month',
        PropertyPeriodEnum::YEAR  => 'Year',
    ],
];
