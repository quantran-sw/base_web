<?php


namespace App\Repository\Traits;


use App\DTO\QueryDTO;

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

    protected function applyFilters(
        QueryBuilder $qb,
        QueryDTO $dto,
        string $rootAlias
    ): void {
        foreach ($dto->filters as $path => $value) {
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

            $field = end($parts);
            $param = str_replace('.', '_', $path);

            $qb
                ->andWhere(sprintf('%s.%s = :%s', $alias, $field, $param))
                ->setParameter($param, $value);
        }
    }

    public function applySorting(QueryBuilder $qb, QueryDTO $dto, string $alias): void
    {
        foreach ($dto->sort as $field => $direction) {
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

        if (!empty($page)) {
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
