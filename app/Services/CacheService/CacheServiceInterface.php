<?php

namespace App\Services\CacheService;

use Illuminate\Database\Eloquent\Model;

interface CacheServiceInterface
{
    public function has(Model $model);

    public function get(Model $model);

    public function put(Model $model, $data = null);

    public function forget(Model $model);
}
