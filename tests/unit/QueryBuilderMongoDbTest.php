<?php

use App\QueryBuilder\QueryMongoDbBuilder;
use PHPUnit\Framework\TestCase;

class QueryBuilderMongoDbTest extends TestCase
{
    public function testQueryBuilderShouldCreateASelectQuery(): void
    {
        $queryBuilder = new QueryMongoDbBuilder();
        $queryBuilder->find('users')
                     ->projection(['name', 'email'])
                     ->filter('created_at', '>=', '2022-01-01 00:00:00');

        $this->assertEquals(
            [
                'collectionName' =>'users',
                'filter' => [
                    'created_at' => [
                        '$gte' => '2022-01-01 00:00:00'
                    ]
                ],
                'options' => [
                    'projection' => [
                        'name' => 1,
                        'email' => 1
                    ]
                ]
            ],
            $queryBuilder->getQueryAsArray()
        );
    }
}