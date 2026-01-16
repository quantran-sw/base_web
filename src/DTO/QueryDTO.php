<?php

namespace App\DTO;

class QueryDTO
{
    // Nếu property này có giá trị, kết quả trả về sẽ là 1 mảng với các dữ liệu tương ứng
    // Nếu muốn lấy dữ liệu từ các bảng relationship, dùng dấu `.` để phân cách. Lưu ý: các bảng relationship trong select sẽ được join bằng `left join`
    // Ví dụ: 'selects' => ['id', 'name', 'school.id', 'school.name', 'school.country.name']
    public array $selects = [];

    // Nếu filter dữ liệu từ bảng relationship, dùng dấu `.` để phân cách. Lưu ý: các bảng relationship trong filter sẽ được join bằng `left join`
    // Ví dụ: 'selects' => ['id', 'name', 'school.id', 'school.name', 'school.country.name']
    public array $filters = [];

    public array $sorts = [];

    public ?int $limit = null;

    // Nếu property này có giá trị, sẽ trả về 1 Pagination
    public ?int $page = null;
}
