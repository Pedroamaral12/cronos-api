<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface BaseRepositoryInterface
{
    public function all(array $columns = ['*']): Collection;
    
    public function paginate(int $perPage = 15, array $columns = ['*']): LengthAwarePaginator;
    
    public function find(int $id, array $columns = ['*']): ?Model;
    
    public function findOrFail(int $id, array $columns = ['*']): Model;
    
    public function create(array $data): Model;
    
    public function update(int $id, array $data): Model;
    
    public function delete(int $id): bool;
    
    public function restore(int $id): Model;
    
    public function query();
    
    public function with(array $relations): self;
    
    public function where(string $column, $operator = null, $value = null): self;
    
    public function orderBy(string $column, string $direction = 'asc'): self;
}
