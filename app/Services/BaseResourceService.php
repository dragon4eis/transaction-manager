<?php


namespace App\Services;


use App\Repositories\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

abstract class BaseResourceService implements BaseResourceServiceInterface
{

    protected BaseRepositoryInterface $repository;

    public function __construct(BaseRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }



    public function paginate(int $per_page, string $search, array $filters, array $oderBy): array
    {
        return $this->repository->listResources($search, $filters, $oderBy)
            ->paginate($per_page ? intval($per_page) : self::DEFAULT_PAGE_ELEMENTS)
            ->toArray();
    }

    public function save(array $attributes): ?Model
    {
        return $this->repository->create($attributes);
    }

    public function update($id, array $attributes): ?Model
    {
        return $this->repository->update($id, $attributes);
    }

    public function find($id): ?Model
    {
        return $this->repository->find($id);
    }

    public function remove(array $ids): bool
    {
        return $this->repository->remove($ids);
    }

    public function list(?string $search = "", ?array $filters = [], ?array $oderBy = []): array
    {
       return  $this->repository->listResources($search ?? "", $filters?? [], $oderBy ?? [])->get()->toArray();
    }
}