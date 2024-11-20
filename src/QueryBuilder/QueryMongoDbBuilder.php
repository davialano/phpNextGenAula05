<?php

namespace App\QueryBuilder;

class QueryMongoDbBuilder
{
    protected array $queryPieces = [];

    public function find(string $collectionName): self
    {
        // implementar...
        return $this;
    }

    public function getQueryAsArray(): array
    {
        return $this->queryPieces;
    }

    public function projection(array $projections): self
    {
        // implementar...
        return $this;
    }

    public function filter(string $fields, string $operator, string $value): self
    {
        // implementar...
        return $this;
    }
}