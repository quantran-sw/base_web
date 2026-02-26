<?php

namespace App\Service;

use App\DTO\InputDTOInterface;
use Doctrine\ORM\EntityManagerInterface;

class BaseEntityService
{
    protected string $entityClass;

    public function __construct(
        protected EntityManagerInterface $entityManager,
    ) {
    }

    public function createEntity(InputDTOInterface $input)
    {
    }
}
