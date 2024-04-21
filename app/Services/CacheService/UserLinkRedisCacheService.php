<?php

namespace App\Services\CacheService;

use App\Models\UserLink;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class UserLinkRedisCacheService implements CacheServiceInterface
{
    public function has(Model $model)
    {
        if (config('app.env') === 'production') {
            /** @var UserLink $model */
            return Cache::has(get_class($model) . ':' . $model->token);
        } else {
            return false;
        }
    }

    public function get(Model $model)
    {
        /** @var UserLink $model */
        return Cache::get(get_class($model) . ':' . $model->token);
    }

    public function put(Model $model, $data = null)
    {
        /** @var UserLink $model */
        Cache::put(get_class($model) . ':' . $model->token, $model, now()->addMinutes(10));
    }

    public function forget(Model $model)
    {
        /** @var UserLink $model */
        Cache::forget(get_class($model) . ':' . $model->token);
    }
}
