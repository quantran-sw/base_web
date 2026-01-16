<?php

namespace App\Service;

use App\DTO\QueryDTO;
use Doctrine\ORM\EntityManagerInterface;

class EntityService
{
    public function __construct(
        protected EntityManagerInterface $entityManager,
    ) {}

    public function findOne(string $entityClass, ?int $id = null, ?QueryDTO $queryDTO = null)
    {

    }

    public function search()
    {

    }
}
