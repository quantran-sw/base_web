<?php

namespace App\Controller;

use App\Service\EntityService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class BaseApiController extends AbstractController
{
    protected string $entityClass;
    protected ?string $createOneInputClass = null;

    public function __construct(
        protected EntityService $entityService,
    ) {
    }

    public function createOne(Request $request)
    {
        $entity = $this->entityService->createEntity($this->entityClass, $request, $this->createOneInputClass);

        dd($entity);
    }
}