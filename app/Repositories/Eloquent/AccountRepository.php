<?php


namespace App\Repositories\Eloquent;


use App\Models\UserTransactionAccount;
use App\Repositories\AccountRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

final class AccountRepository extends BaseRepository implements AccountRepositoryInterface
{
    public function __construct(UserTransactionAccount $model)
    {
        parent::__construct($model);
    }

    public function listResources(string $search = "", array $filters = [], array $oderBy = []): ?Builder
    {
        return parent::listResources($search, $filters, $oderBy)
            ->with('user');
    }
}