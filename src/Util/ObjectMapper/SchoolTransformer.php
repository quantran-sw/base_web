<?php

namespace App\Util\ObjectMapper;

use App\Entity\School;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\ObjectMapper\TransformCallableInterface;

class SchoolTransformer implements TransformCallableInterface
{
    public function __construct(private EntityManagerInterface $em) {}

    public function __invoke(mixed $value, object $source, ?object $target): mixed
    {
        if (null === $value) {
            return null;
        }

        return $this->em->getRepository(School::class)->find($value);
    }
}