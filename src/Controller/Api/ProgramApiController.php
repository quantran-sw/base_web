<?php

namespace App\Controller\Api;

use App\Controller\BaseApiController;
use App\DTO\Program\ProgramCreateOneInput;
use App\DTO\Program\ProgramInput;
use App\DTO\QueryDTO;
use App\DTO\School\SchoolInput;
use App\Entity\Program;
use App\Entity\School;
use App\Service\EntityService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class ProgramApiController extends BaseApiController
{
    protected string $entityClass = Program::class;
    protected ?string $createOneInputClass = ProgramCreateOneInput::class;

    #[Route(
        path: "/api/program/create-one",
        name: "api_program_create_one",
        methods: ["POST"],
    )]
    public function createOne(Request $request)
    {
        return parent::createOne($request);
    }
}
