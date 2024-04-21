<?php

namespace App\Services\CacheService;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class RedisCacheService implements CacheServiceInterface
{
    public function has(Model $model)
    {
        if (config('app.env') === 'production') {
            return Cache::has(get_class($model) . ':' . $model->id);
        } else {
            return false;
        }
    }

    public function get(Model $model)
    {
        return Cache::get(get_class($model) . ':' . $model->id);
    }

    public function put(Model $model, $data = null)
    {
        Cache::put(get_class($model) . ':' . $model->id, $model, now()->addMinutes(10));
    }

    public function forget(Model $model)
    {
        Cache::forget(get_class($model) . ':' . $model->id);
    }
}
