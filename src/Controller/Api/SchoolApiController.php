<?php

namespace App\Controller\Api;

use App\Controller\BaseApiController;
use App\DTO\QueryDTO;
use App\DTO\School\SchoolInput;
use App\Entity\School;
use App\Service\EntityService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class SchoolApiController extends BaseApiController
{
    protected string $entityClass = School::class;
    protected ?string $createOneInputClass = SchoolInput::class;

    #[Route(
        path: "/api/school/get-list",
        name: "api_school_get_list",
        methods: ["GET"],
    )]
    public function getList(Request $request)
    {
        $queryDTO = (new QueryDTO($request->query->all()));

        $result = $this->entityService->search(School::class, $queryDTO);

        return $this->json($result);
    }

    #[Route(
        path: "/api/school/create-one",
        name: "api_school_create_one",
        methods: ["POST"],
    )]
    public function createOne(Request $request)
    {
        return parent::createOne($request);
    }
}
