<?php


namespace App\Repository\Traits;


use App\DTO\QueryDTO;
use Doctrine\ORM\QueryBuilder;

trait QueryBuilderTrait
{
    public function buildQuery(
        QueryDTO $dto,
        string $alias = 'q'
    ): QueryBuilder {
        $qb = $this->createQueryBuilder($alias);

        $this->applyFilters($qb, $dto, $alias);
        $this->applySorting($qb, $dto, $alias);
        $this->applyPagination($qb, $dto);

        return $qb;
    }

    // protected function applyFilters(
    //     QueryBuilder $qb,
    //     QueryDTO $dto,
    //     string $rootAlias
    // ): void {
    //     foreach ($dto->filters as $path => $value) {
    //         $parts = explode('.', $path);

    //         $alias = $this->resolveJoins($qb, $rootAlias, $path);

    //         $field = end($parts);
    //         $param = str_replace('.', '_', $path);

    //         $qb
    //             ->andWhere(sprintf('%s.%s = :%s', $alias, $field, $param))
    //             ->setParameter($param, $value);
    //     }
    // }

    protected function applyFilters(
        QueryBuilder $qb,
        QueryDTO $dto,
        string $rootAlias
    ): void {
        foreach ($dto->filters as $pathOp => $value) {
            // Detect operator suffix (e.g. _like, _eq, _gte)
            if (preg_match('/(.*)_([a-z]+)$/i', $pathOp, $matches)) {
                $path = $matches[1];
                $operator = strtolower($matches[2]);
            } else {
                $path = $pathOp;
                $operator = 'eq'; // default operator
            }

            $parts = explode('.', $path);
            $alias = $this->resolveJoins($qb, $rootAlias, $path);
            $field = end($parts);
            $param = str_replace(['.', '_'], '_', $pathOp);

            switch ($operator) {
                case 'like':
                    $qb->andWhere(sprintf('%s.%s LIKE :%s', $alias, $field, $param))
                        ->setParameter($param, '%' . $value . '%');
                    break;
                case 'eq':
                    $qb->andWhere(sprintf('%s.%s = :%s', $alias, $field, $param))
                        ->setParameter($param, $value);
                    break;
                case 'neq':
                    $qb->andWhere(sprintf('%s.%s != :%s', $alias, $field, $param))
                        ->setParameter($param, $value);
                    break;
                case 'gt':
                    $qb->andWhere(sprintf('%s.%s > :%s', $alias, $field, $param))
                        ->setParameter($param, $value);
                    break;
                case 'gte':
                    $qb->andWhere(sprintf('%s.%s >= :%s', $alias, $field, $param))
                        ->setParameter($param, $value);
                    break;
                case 'lt':
                    $qb->andWhere(sprintf('%s.%s < :%s', $alias, $field, $param))
                        ->setParameter($param, $value);
                    break;
                case 'lte':
                    $qb->andWhere(sprintf('%s.%s <= :%s', $alias, $field, $param))
                        ->setParameter($param, $value);
                    break;
                case 'in':
                    if (is_array($value)) {
                        $qb->andWhere(sprintf('%s.%s IN (:%s)', $alias, $field, $param))
                            ->setParameter($param, $value);
                    }
                    break;
                case 'notin':
                    if (is_array($value)) {
                        $qb->andWhere(sprintf('%s.%s NOT IN (:%s)', $alias, $field, $param))
                            ->setParameter($param, $value);
                    }
                    break;
                // Add more operators as needed
                default:
                    // fallback to eq
                    $qb->andWhere(sprintf('%s.%s = :%s', $alias, $field, $param))
                        ->setParameter($param, $value);
                    break;
            }
        }
    }

    public function applySorting(QueryBuilder $qb, QueryDTO $dto, string $alias): void
    {
        foreach ($dto->sorts as $field => $direction) {
            $qb->addOrderBy(
                sprintf('%s.%s', $alias, $field),
                strtoupper($direction) === 'DESC' ? 'DESC' : 'ASC'
            );
        }
    }

    public function applyPagination(QueryBuilder $qb, QueryDTO $dto): void
    {
        if (!empty($dto->limit)) {
            $qb->setMaxResults($dto->limit);
        }

        if (!empty($dto->page)) {
            $qb->setFirstResult(($dto->page - 1) * ($dto->limit ?? 0));
        }
    }

    public function hasJoin(QueryBuilder $qb, string $alias): bool
    {
        $joins = $qb->getDQLPart('join');

        foreach ($joins as $joinGroup) {
            foreach ($joinGroup as $join) {
                if ($join->getAlias() === $alias) {
                    return true;
                }
            }
        }

        return false;
    }

    public function resolveJoins(QueryBuilder $qb, string $rootAlias, $path)
    {
        $parts = explode('.', $path);

        $alias = $rootAlias;

        // Build joins for relations
        for ($i = 0; $i < count($parts) - 1; $i++) {
            $relation = $parts[$i];
            $joinAlias = $alias . '_' . $relation;

            if (!$this->hasJoin($qb, $joinAlias)) {
                $qb->leftJoin("$alias.$relation", $joinAlias);
            }

            $alias = $joinAlias;
        }

        return $alias;
    }
}
