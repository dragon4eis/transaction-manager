<?php


namespace App\Repositories\Eloquent;


use App\Models\User;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

final class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function remove(array $ids): bool
    {
        throw new \Exception("Unsupported action");
    }

    public function update($id, array $attributes): Model
    {
        return parent::update($id, ['name' => $attributes['name']]);
    }
}