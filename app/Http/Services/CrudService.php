<?php

namespace App\Http\Services;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface CrudService
{
    public function findAll(): Collection;

    public function findById(int $id): Model;

    public function store(array $attributes): Model;

    public function update(int $id, array $attributes): Model;

    public function deleteById(int $id): int;
}
