<?php

namespace App\DTO;

use Symfony\Component\HttpFoundation\Request;

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

    // Property này dùng để lấy dữ liệu trả về theo một nhóm context nhất định thay vì lấy từng field như trong `selects`.
    // Các field trong context sẽ được từng entity định nghĩa trong Repository của nó
    // Ví dụ: context `school_basic` sẽ chỉ trả về các field cơ bản như `id, name, slug, status`, nếu có thêm context `country_basic` thì dữ liệu trả về sẽ thêm field `country.id, country.name`
    public array $contexts = [];

    public function __construct(array $queryParams)
    {
        $this->selects = $queryParams['selects'] ?? [];

        // Extract filters: keys with underscores indicate operator, else equality
        $this->filters = [];

        if (isset($queryParams['filters']) && is_array($queryParams['filters'])) {
            foreach ($queryParams['filters'] as $key => $value) {
                $this->filters[$key] = $value;
            }
        }

        // Extract sorts: can be array 'sorts' => ['id' => 'desc']
        $this->sorts = $queryParams['sorts'] ?? [];

        $this->limit = isset($queryParams['limit']) ? (int)$queryParams['limit'] : null;

        $this->page = isset($queryParams['page']) ? (int)$queryParams['page'] : null;

        $this->contexts = $queryParams['contexts'] ?? [];
    }
}
