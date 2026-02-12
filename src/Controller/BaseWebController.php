<?php

namespace App\Controller;

use App\Constant;
use App\Service\SeoService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BaseWebController extends AbstractController
{
    public function __construct(
        protected SeoService $seoService,
    ) {
    }
}