<?php


namespace App\Repositories\Eloquent;


use App\Repositories\BaseRepositoryInterface;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

abstract class BaseRepository implements BaseRepositoryInterface
{
    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function listResources(string $search = "", array $filters = [], array $oderBy = []): ?Builder
    {
        return $this->model
            //apply search filter or additional filters
            ->where(function ($query) use ($filters, $search) {
                if ($filters) {
                    //todo-all set more agile filter parser when needed
                    foreach ($filters as $column => $value) {
                        if($column === "ids"){
                            $query->whereIn('id', $value);
                        } else {
                            $query->where($column, '=', $value);
                        }

                    }
                }
                if ($search) {
                    if (substr($search, 0, 1) === '#') {
                        $query->whereIn('tags', explode(';', ltrim($search, '#')));
                    } else {
                        $query->where('name', 'like', $search);
                    }
                }
            })
            // order elements by given orderBy or sort by "from New to Old"
            ->when($oderBy, function ($query) use ($oderBy) {
                foreach ($oderBy as $column => $direction)
                    $query->orderBy($column, $direction);
            }, function ($query) {
                $query->orderBy('id', 'asc');
            });
    }

    public function create(array $attributes): Model
    {
        $this->model->fill($attributes);
        throw_if(!$this->model->save(), new Exception("Model was not saved!"));
        return $this->model;
    }

    public function update($id, array $attributes): Model
    {
        $element = $this->find($id);
        $element->update($attributes);
        return $element;
    }

    public function find($id): ?Model
    {
        return $this->model->findOrFail($id);
    }

    public function remove(array $ids): bool
    {
        return $this->model->destroy($ids);
    }
}