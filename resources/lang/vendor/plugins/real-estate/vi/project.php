<?php

use Botble\RealEstate\Enums\ProjectStatusEnum;

return [
    'name'     => 'Dự án',
    'create'   => 'Thêm dự án',
    'edit'     => 'Sửa',
    'form'     => [
        'general_info' => 'Thông tin chung',
        'name'         => 'Tên dự án',
        'description'  => 'Mô tả',
        'basic_info'   => 'Thông tin cơ bản',
        'location'     => 'Địa chỉ',
        'investor'     => 'Chủ đầu tư',
        'number_block' => 'Số block',
        'number_floor' => 'Số tầng',
        'number_flat'  => 'Số căn hộ',
        'date_finish'  => 'Ngày hoàn thành',
        'date_sell'    => 'Ngày mở bán',
        'images'       => 'Hình ảnh',
        'price_from'   => 'Giá thấp nhất',
        'price_to'     => 'Giá cao nhất',
        'currency'     => 'Loại tiền',
        'city'         => 'Thành phố',
        'category' => 'Loại dự án',
    ],
    'statuses' => [
        ProjectStatusEnum::NOT_AVAILABLE => 'Không khả dụng',
        ProjectStatusEnum::PRE_SALE      => 'Chuẩn bị mở bán',
        ProjectStatusEnum::SELLING       => 'Đang bán',
        ProjectStatusEnum::SOLD          => 'Đã bán',
        ProjectStatusEnum::BUILDING      => 'Đang xây dựng',
    ],
];
