<?php

namespace App\UseCases;

use App\DTO\SearchDTO;
use App\Interfaces\CommandInterface;
use App\QueryBuilder\QueryBuilder;
use App\Repository\UserRepository;

class GetUsersUseCase implements CommandInterface
{
    /**
     * @param SearchDTO $searchDTO
     * @param QueryBuilder $queryBuilder
     * @param UserRepository $userRepository
     */
    public function __construct(
        protected SearchDTO $searchDTO,
        protected QueryBuilder $queryBuilder,
        protected UserRepository $userRepository
    )
    {
    }

    public function execute(): array
    {
        $fields = $this->searchDTO->fields;
        [$field, $compare, $value] = $this->searchDTO->search;

        $query = $this->queryBuilder
                            ->select($fields)
                            ->from('users')
                            ->where($field, $compare, $value);

        // não implementado por ser um exercício
        $users = $this->userRepository->findByQueryBuilder($query);
        // $fakeUsers = array_fill(0, 10, 0);

        return $users;
    }
}