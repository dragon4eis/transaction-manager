<?php


namespace App\Services;


use App\Repositories\UserRepositoryInterface;

final class UserService extends BaseResourceService implements UserServiceInterface
{
    public function __construct(UserRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }
}