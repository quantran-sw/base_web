<?php

namespace App\Service\Entity;

use App\Service\BaseEntityService;
use Doctrine\ORM\EntityManagerInterface;

class SchoolService
{
    public function __construct(
        protected EntityManagerInterface $entityManager,
    ) {
    }
}
