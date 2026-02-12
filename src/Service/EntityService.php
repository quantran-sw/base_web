<?php

namespace App\Service;

use App\DTO\InputDTOInterface;
use App\DTO\QueryDTO;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\ObjectMapper\ObjectMapperInterface;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class EntityService
{
    public function __construct(
        protected EntityManagerInterface $entityManager,
        protected ValidatorInterface $validator,
        protected ObjectMapperInterface $objectMapper,
    ) {}

    public function validate(object $object, bool $throwException = true)
    {
        $violations = $this->validator->validate($object);

        if ($throwException) {
            if (count($violations) > 0) {
                // $messages = [];
                // foreach ($violations as $violation) {
                //     $messages[] = $violation->getPropertyPath() . ': ' . $violation->getMessage();
                // }

                // throw new \InvalidArgumentException('Validation failed: ' . implode('; ', $messages));

                throw new ValidationFailedException($object, $violations);
            }
        }

        return $violations;
    }

    public function transformToInput(Request|array $data, string $inputClass)
    {
        if ($data instanceof Request) {
            $data = $data->request->all();
        }

        $inputObject = new $inputClass();
        
        // Map data to inputObject (assuming public properties or use setters)
        foreach ($data as $key => $value) {
            // Set only if property exists, or adapt to your input object structure
            if (property_exists($inputObject, $key)) {
                $inputObject->$key = $value;
            }
        }

        return $inputObject;
    }

    public function transformToEntity(object $input, object|string $entity)
    {
        return $this->objectMapper->map($input, $entity);
    }

    public function findOne(string $entityClass, ?int $id = null, ?QueryDTO $queryDTO = null)
    {

    }

    public function search(string $entityClass, QueryDTO $queryDTO)
    {
        /** @var ServiceEntityRepository */
        $repository = $this->entityManager->getRepository($entityClass);

        if (!$repository) {
            throw new \InvalidArgumentException("The Repository of {$entityClass} is not found.");
        }

        if (method_exists($repository, 'buildQuery')) {
            $queryBuilder = $repository->buildQuery($queryDTO);
        } else {
            $queryBuilder = $repository->createQueryBuilder('q');
        }

        dd($queryBuilder->getQuery()->getSQL(), $queryBuilder->getParameters());
    }

    public function createEntity(string $entityClass, Request|array $data, ?string $inputClass = null): object
    {
        if ($data instanceof Request) {
            $data = $data->request->all();
        }

        $inputObject = null;

        if ($inputClass !== null) {
            $inputObject = $this->transformToInput($data, $inputClass);

            $this->validate($inputObject);
        } else {
            $inputObject = (object) $data;
        }

        $entity = $this->transformToEntity($inputObject, $entityClass);

        $this->entityManager->persist($entity);
        $this->entityManager->flush();

        return $entity;
    }
}
