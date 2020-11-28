<?php


namespace App\Repositories;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

interface BaseRepositoryInterface
{
    /**
     * List resources
     *
     * @param String $search
     *
     * @param array  $filters
     * @param array  $oderBy
     *
     * @return Builder|null
     */
    public function listResources(string $search = "", array $filters = [], array $oderBy = []): ?Builder;


    /**
     * Creates new resource record
     *
     * @param array $attributes
     *
     * @return Model
     */
    public function create(array $attributes): Model;

    /**
     * @param string|int $id
     * @param array      $attributes
     *
     * @return Model
     */
    public function update($id, array $attributes): Model;

    /**
     * Returns resource by provided $id
     *
     * @param $id
     *
     * @return Model|null
     */
    public function find($id): ?Model;

    /**
     * Delete multiple resources by givens ids
     *
     * @param array $ids
     *
     * @return bool
     */
    public function remove(array $ids): bool;
}