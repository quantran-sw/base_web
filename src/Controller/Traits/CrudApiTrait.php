<?php

namespace App\Controller\Traits;

use App\DTO\InputDTOInterface;
use Symfony\Component\HttpFoundation\Request;

trait CrudApiTrait
{
    public function getList(Request $request)
    {
    }

    public function getOne(Request $request)
    {

    }

    public function createOne(InputDTOInterface $input)
    {

    }

    public function updateOne(int $id)
    {

    }

    public function deleteOne(int $id)
    {

    }
}