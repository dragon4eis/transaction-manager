<?php


namespace App\Services;


use Illuminate\Database\Eloquent\Model;

interface BaseResourceServiceInterface
{
    public const DEFAULT_PAGE_ELEMENTS = 12;

    /**
     * Returns pagination data
     *
     * @param int         $per_page
     * @param string|null $search
     *
     * @param array|null  $filters
     * @param array|null  $oderBy
     *
     * @return array
     */
    public function paginate(int $per_page, string $search, array $filters, array $oderBy): array;

    /**
     * Creates new resource record
     *
     * @param array $attributes
     *
     * @return Model|null
     */
    public function save(array $attributes): ?Model;

    /**
     * @param string|int $id
     * @param array      $attributes
     *
     * @return Model|null
     */
    public function update($id, array $attributes): ?Model;

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


    /**
     * Constructs get request for multiple resources
     *
     * @param string|null $search
     * @param array|null  $filters
     * @param array|null  $oderBy
     *
     * @return array
     */
    public function list(?string $search = "", ?array $filters = [], ?array $oderBy = []): array;
}