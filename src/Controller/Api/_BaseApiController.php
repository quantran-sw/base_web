<?php

namespace App\Controller\Api;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class _BaseApiController extends AbstractController
{
    public function __construct() {}

    public function getList(Request $request)
    {}

    public function getOne(Request $request)
    {}

    public function createOne(Request $request)
    {}

    public function updateOne(Request $request)
    {}

    public function deleteOne(Request $request)
    {}
}
