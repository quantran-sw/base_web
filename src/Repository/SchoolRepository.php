<?php

namespace App\Repository;

class SchoolRepository extends _AbstractBaseRepository
{
    protected $allowedFilters = ['id', 'name', 'slug'];
    protected $allowedSorts = ['id', 'name'];
}
