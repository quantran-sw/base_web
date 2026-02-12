<?php

namespace App\Controller\Web;

use App\Controller\BaseWebController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends BaseWebController
{
    #[Route('/', name: 'web_homepage')]
    public function index(): Response
    {
        return $this->render('web/page/home.html.twig');
    }
}