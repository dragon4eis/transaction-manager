<?php


namespace App\Services;


use App\Repositories\TransactionRepositoryInterface;

final class TransactionService extends BaseResourceService implements TransactionServiceInterface
{
    public function __construct(TransactionRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }
}