<?php


namespace App\Services;


use App\Repositories\AccountRepositoryInterface;

final class AccountService extends BaseResourceService implements AccountServiceInterface
{
    public function __construct(AccountRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }
}