<?php


namespace App\Repositories\Eloquent;


use App\Models\Transaction;
use App\Repositories\TransactionRepositoryInterface;

final class TransactionRepository extends BaseRepository implements TransactionRepositoryInterface
{
    public function __construct(Transaction $model)
    {
        parent::__construct($model);
    }
}