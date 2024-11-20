<?php

namespace App\QueryBuilder;

class QueryBuilder
{
    /**
     * @var array<int, string>
     */
    protected array $queryPieces = [];

    public function select(array $tableFields): self
    {
        $this->queryPieces['SELECT'] = implode(', ', $tableFields);
        return $this;
    }

    public function from(string $tableName): self
    {
        $this->queryPieces['FROM'] = $tableName;
        return $this;
    }

    public function where(string $field, string $compare, string $value): self
    {
        $this->queryPieces['WHERE'] = "$field $compare '$value'";
        return $this;
    }

    public function getQueryAsArray(): array
    {
        return $this->queryPieces;
    }
}