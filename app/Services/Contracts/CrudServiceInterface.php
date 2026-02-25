<?php

namespace App\Services\Contracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface CrudServiceInterface
{
    public function all(array $columns = ['*']): Collection;
    
    public function paginate(int $perPage = 15, array $columns = ['*']): LengthAwarePaginator;
    
    public function find(int $id, array $columns = ['*']): ?Model;
    
    public function findOrFail(int $id, array $columns = ['*']): Model;
    
    public function create(array $data): Model;
    
    public function update(int $id, array $data): Model;
    
    public function delete(int $id): bool;
    
    public function restore(int $id): Model;
    
    public function getSelect(array $columns = ['id', 'name']): Collection;
}
