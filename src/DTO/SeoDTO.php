<?php

namespace App\DTO;

use App\Constant;

class SeoDTO
{
    public function __construct(
        public string $title = Constant::PAGE_TITLE,
        public string $description = Constant::PAGE_DESCRIPTION,
        public ?string $imageUrl = null,
        public string $type = 'website'
    ) {}
}