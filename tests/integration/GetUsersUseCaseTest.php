<?php
namespace integration;

use App\Adapter\QueryBuilderAdapter;
use App\DTO\SearchDTO;
use App\QueryBuilder\QueryBuilder;
use App\QueryBuilder\QueryMongoDbBuilder;
use App\Repository\UserRepository;
use App\UseCases\GetUsersUseCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(GetUsersUseCase::class)]
class GetUsersUseCaseTest extends TestCase
{
    protected QueryBuilder $queryBuilderMock;

    protected UserRepository $userRepositoryMock;

    protected UserRepository $userRepositoryMongoDbMock;

    protected function setUp(): void
    {
        $this->userRepositoryMock = $this->createMock(UserRepository::class);
    }

    public function testGetUsersUseCaseShouldReturnUserObject()
    {
        $this->userRepositoryMock
            ->method('findByQueryBuilder')
            ->with($this->isInstanceOf(QueryBuilder::class))
            ->willReturnCallback(function (QueryBuilder $queryBuilder) {
                $this->assertEquals(
                    [
                        'SELECT' => 'name, email',
                        'FROM' => 'users',
                        'WHERE' => "created_at >= '2022-01-01 00:00:00'"
                    ],
                    $queryBuilder->getQueryAsArray()
                );
                return array_fill(0, 10, 1);
            })
        ;

        $searchDTO = new SearchDTO();
        $searchDTO->fields = ['name', 'email'];
        $searchDTO->search = ['created_at', '>=', '2022-01-01 00:00:00'];

        $getUsersUseCase = new GetUsersUseCase($searchDTO, new QueryBuilder(), $this->userRepositoryMock);
        $users = $getUsersUseCase->execute();

        $this->assertCount(10, $users);
    }

    public function testGetUsersUseCaseWithMongoDbShouldReturnUserObject()
    {
        $this->userRepositoryMock
            ->method('findByQueryBuilder')
            ->with($this->isInstanceOf(QueryBuilder::class))
            ->willReturnCallback(function (QueryBuilder $queryBuilder) {
                $this->assertEquals(
                    [
                        'collectionName' => 'users',
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
                return array_fill(0, 10, 1);
            })
        ;

        $searchDTO = new SearchDTO();
        $searchDTO->fields = ['name', 'email'];
        $searchDTO->search = ['created_at', '>=', '2022-01-01 00:00:00'];

        $getUsersUseCase = new GetUsersUseCase(
            $searchDTO,
            new QueryMongoDbBuilder(),
            $this->userRepositoryMock
        );

        $users = $getUsersUseCase->execute();

        $this->assertCount(10, $users);
    }
}