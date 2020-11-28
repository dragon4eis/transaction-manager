<?php


namespace App\Repositories\Eloquent;


use App\Models\Transaction;
use App\Repositories\TransactionRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;

final class TransactionRepository extends BaseRepository implements TransactionRepositoryInterface
{
    public function __construct(Transaction $model)
    {
        parent::__construct($model);
    }

    public function listResources(string $search = "", array $filters = [], array $oderBy = []): ?Builder
    {
        return parent::listResources($search, $filters, $oderBy)
            ->with('account', function ($query){
                $query->with('user');
            });
    }
}