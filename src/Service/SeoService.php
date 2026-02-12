<?php

namespace App\Service;

use App\Constant;
use App\DTO\SeoDTO;
use Symfony\Component\Asset\Packages;
use Symfony\Component\HttpFoundation\RequestStack;

class SeoService
{
    private ?SeoDTO $seoPage = null;

    public function __construct(
        private RequestStack $requestStack,
        private Packages $assetManager
    ) {
        // Khởi tạo mặc định
        $this->seoPage = new SeoDTO();
    }

    public function setSeo(?string $title = null, ?string $description = null, ?string $imageUrl = null, string $type = 'website'): void
    {
        $request = $this->requestStack->getCurrentRequest();
    
        // Nếu không truyền title/desc, lấy từ Constant
        $seoTitle = $title ?? Constant::PAGE_TITLE;
        $seoDesc = $description ?? Constant::PAGE_DESCRIPTION;
        
        // Xử lý Image URL tuyệt đối
        if (!$imageUrl) {
            $imageUrl = $request->getUriForPath(Constant::PAGE_IMAGE_PATH);
        } elseif (!str_starts_with($imageUrl, 'http')) {
            $imageUrl = $request->getUriForPath($imageUrl);
        }

        $this->seoPage = new SeoDTO($seoTitle, $seoDesc, $imageUrl, $type);
    }

    public function getSeo(): SeoDTO
    {
        return $this->seoPage;
    }
}