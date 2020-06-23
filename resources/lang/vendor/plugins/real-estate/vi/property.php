<?php

use Botble\RealEstate\Enums\PropertyPeriodEnum;
use Botble\RealEstate\Enums\PropertyStatusEnum;
use Botble\RealEstate\Enums\PropertyTypeEnum;

return [
    'name'     => 'Nhà - Căn hộ',
    'create'   => 'Thêm mới',
    'edit'     => 'Sửa',
    'form'     => [
        'main_info'        => 'Thông tin',
        'basic_info'       => 'Thông tin cơ bản',
        'description'      => 'Mô tả',
        'name'             => 'Tiêu đề',
        'type'             => 'Loại',
        'images'           => 'Hình ảnh',
        'button_add_image' => 'Thêm ảnh',
        'location'         => 'Địa chỉ',
        'number_bedroom'   => 'Số phòng ngủ',
        'number_bathroom'  => 'Số phòng tắm',
        'number_floor'     => 'Số tầng',
        'square'           => 'Diện tích (m2)',
        'price'            => 'Giá',
        'features'         => 'Tiện ích',
        'project'          => 'Dự án',
        'date'             => 'Thông tin thời gian',
        'currency'         => 'Loại tiền',
        'city'             => 'Thành phố',
        'period'           => 'Chu kỳ',
        'category'    => 'Loại nhà',
    ],
    'statuses' => [
        PropertyStatusEnum::NOT_AVAILABLE => 'Không khả dụng',
        PropertyStatusEnum::PRE_SALE      => 'Chuẩn bị mở bán',
        PropertyStatusEnum::SELLING       => 'Đang bán',
        PropertyStatusEnum::SOLD          => 'Đã bán',
        PropertyStatusEnum::RENTING       => 'Đang mở thuê',
        PropertyStatusEnum::RENTED        => 'Đã cho thuê',
        PropertyStatusEnum::BUILDING      => 'Đang xây dựng',
    ],
    'types'    => [
        PropertyTypeEnum::SALE => 'Nhà bán',
        PropertyTypeEnum::RENT => 'Nhà cho thuê',
    ],
    'periods'  => [
        PropertyPeriodEnum::DAY   => 'Ngày',
        PropertyPeriodEnum::MONTH => 'Tháng',
        PropertyPeriodEnum::YEAR  => 'Năm',
    ],
];
