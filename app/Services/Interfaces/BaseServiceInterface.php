<?php

namespace App\Services\Interfaces;

use Illuminate\Database\Eloquent\Model;

interface BaseServiceInterface
{
    public function create(array $data): ?Model;

    public function list();

    public function getById(int $id): Model;
}
