<?php

namespace App\Repository;

use App\QueryBuilder\QueryBuilder;

class UserRepository
{
    public function findByQueryBuilder(QueryBuilder $query): array
    {
        return $this;
    }
}