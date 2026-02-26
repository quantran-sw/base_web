<?php

namespace App\Controller;

use App\Service\EntityService;
use App\Service\EntityServiceManager;
use App\Service\EntityServiceProvider;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class BaseApiController extends AbstractController
{
    protected string $entityClass;
    protected ?string $createOneInputClass = null;

    public function __construct(
        protected EntityService $entityService,
        protected EntityServiceManager $entityServiceManager,
    ) {
    }

    public function createOne(Request $request)
    {
        $service = $this->entityServiceManager->getService($this->entityClass);
        $entity = $service->createEntity($request, $this->createOneInputClass);

        // $entity = $this->entityService->createEntity($this->entityClass, $request, $this->createOneInputClass);

        dd($entity);
    }
}