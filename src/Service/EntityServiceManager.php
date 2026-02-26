<?php

namespace App\Service;

use App\Entity\Program;
use App\Entity\School;
use App\Service\Entity\ProgramService;
use App\Service\Entity\SchoolService;
use Psr\Container\ContainerInterface;
use Symfony\Contracts\Service\ServiceSubscriberInterface;

class EntityServiceManager implements ServiceSubscriberInterface
{
    private ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public static function getSubscribedServices(): array
    {
        return [
            School::class => SchoolService::class,
            Program::class => ProgramService::class,
        ];
    }

    public function getService(string $entityClass): object
    {
        if (!$this->container->has($entityClass)) {
            throw new \InvalidArgumentException("No service registered for entity: $entityClass");
        }

        return $this->container->get($entityClass);
    }
}