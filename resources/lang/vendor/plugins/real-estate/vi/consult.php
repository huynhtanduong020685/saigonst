<?php

use Botble\RealEstate\Enums\ConsultStatusEnum;

return [
    'name'                => 'Tư vấn',
    'edit'                => 'Xem tư vấn',
    'statuses'            => [
        ConsultStatusEnum::READ   => 'Đã đọc',
        ConsultStatusEnum::UNREAD => 'Chưa đọc',
    ],
    'phone'               => 'Điện thoại',
    'settings'            => [
        'email' => [
            'title'       => 'Tư vấn',
            'description' => 'Cấu hình email cho tư vấn',
            'templates'   => [
                'notice_title'       => 'Gửi thông báo tới quản trị viên',
                'notice_description' => 'Mẫu email gửi tới quản trị viên khi có yêu cầu tư vấn mới',
            ],
        ],
    ],
    'content'             => 'Chi tiết',
    'consult_information' => 'Nội dung yêu cầu tư vấn',
    'email'               => [
        'header'  => 'Email',
        'title'   => 'Yêu cầu tư vấn mới',
        'success' => 'Gửi yêu cầu tư vấn thành công!',
        'failed'  => 'Gửi yêu cầu tư vấn thất bại, vui lòng thử lại sau!',
    ],
    'name.required'       => 'Tên là bắt buộc',
    'email.required'      => 'Email là bắt buộc',
    'email.email'         => 'Địa chỉ email không hợp lệ',
    'content.required'    => 'Nội dung là bắt buộc',
    'consult_sent_from'   => 'Yêu cầu tư vấn này được gửi từ',
    'time'                => 'Thời gian',
    'consult_id'          => 'Mã yêu cầu tư vấn',
    'form_name'           => 'Tên',
    'form_email'          => 'Email',
    'form_phone'          => 'Điện thoại',
    'mark_as_read'        => 'Đánh dấu đã đọc',
    'mark_as_unread'      => 'Đánh dấu chưa đọc',
    'new_consult_notice'  => 'Bạn có <span class="bold">:count</span> yêu cầu tư vấn mới',
    'view_all'            => 'Xem tất cả',
    'project'             => 'Dự án',
    'property'            => 'Nhà ở - Căn hộ',
];
