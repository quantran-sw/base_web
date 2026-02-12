<?php

namespace App\Twig;

use App\Service\SeoService;
use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;

class SeoExtension extends AbstractExtension implements GlobalsInterface
{
    public function __construct(
        private SeoService $seoService
    ) {}

    public function getGlobals(): array
    {
        return [
            'seoService' => $this->seoService, // Dùng trong các template để đặt các thẻ cho SEO
        ];
    }
}