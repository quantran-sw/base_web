<?php

namespace App\DTO;

use AutoMapperPlus\Configuration\AutoMapperConfig;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Generic mapper for common entities
 */
class EntityMapper
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function basicMap(object $source, object $target)
    {
        $mapperConfig = new AutoMapperConfig();
    }
}
