<?php

namespace App\Repository;

use App\DTO\QueryDTO;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

abstract class _AbstractBaseRepository extends ServiceEntityRepository
{
    protected $allowedFilters = [];
    protected $allowedSorts = [];

    public function __construct(ManagerRegistry $registry)
    {
        $repositoryClass = get_class($this);

        $classReflection = new \ReflectionClass($repositoryClass);
        $entityName = str_replace('Repository', '', $classReflection->getShortName());
        $entityClass = "App\\Entity\\{$entityName}";

        if (!class_exists($entityClass)) {
            throw new \Exception("Entity Not Found");
        }

        parent::__construct($registry, $entityClass);
    }

    public function buildQuery(QueryDTO $queryDTO): QueryBuilder
    {
        $qb = $this->createQueryBuilder('q');

        // Filters
        foreach ($queryDTO->filters as $field => $value) {
            if (!in_array($field, $this->allowedFilters ?? [], true)) {
                continue;
            }

            $operator = '=';
            
            if (is_array($value)) {
                $filterOperator = array_key_first($value);
                $filterValue = $value[$filterOperator];
                $operator = $this->convertFilterOperator($filterOperator);
                $value = $this->convertFilterValue($filterOperator, $filterValue);
            }

            $paramName = 'param_' . $field;

            $qb->andWhere("q.$field {$operator} :$paramName")
            ->setParameter($paramName, $value);
        }

        // Sorting
        foreach ($queryDTO->sorts as $field => $direction) {
            if (!in_array($field, $this->allowedSorts ?? [], true)) {
                continue;
            }

            $direction = strtoupper($direction) === 'DESC' ? 'DESC' : 'ASC';

            $qb->addOrderBy("q.$field", $direction);
        }

        // Pagination
        if ($queryDTO->limit) {
            $qb->setMaxResults($queryDTO->limit);
        }

        if ($queryDTO->page && $queryDTO->limit) {
            $qb->setFirstResult(($queryDTO->page - 1) * $queryDTO->limit);
        }

        return $qb;
    }

    private function convertFilterOperator(string $filterOperator)
    {
        switch ($filterOperator) {
            default:
                return $filterOperator;
            case 'eq':
                return '=';
            case 'neq':
                return '<>';
            case 'gt':
                return '>';
            case 'gte':
                return '>=';
            case 'lt':
                return '<';
            case 'lte':
                return '<=';
            case 'isNot':
                return 'IS NOT';
            case 'startsLike':
            case 'endsLike':
                return 'LIKE';
        }
    }

    private function convertFilterValue(string $filterOperator, string $filterValue)
    {
        switch ($filterOperator) {
            default:
                return $filterValue;
            case 'like':
            case 'notLike':
                return '%' . $filterValue . '%';
            case 'startsLike':
                return $filterValue . '%';
            case 'endsLike':
                return '%' . $filterValue;
        }
    }
}
