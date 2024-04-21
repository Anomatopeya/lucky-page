<?php

namespace App\Providers;

use App\Http\Middleware\CheckAccessLink;
use App\Models\UserLink;
use App\Repositories\Game\EloquentGameResultRepository;
use App\Repositories\Game\GameResultRepositoryInterface;
use App\Repositories\User\EloquentUserLinkRepository;
use App\Repositories\User\EloquentUserRepository;
use App\Repositories\User\UserLinkRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use App\Services\CacheService\CacheServiceInterface;
use App\Services\CacheService\RedisCacheService;
use App\Services\CacheService\UserLinkRedisCacheService;
use App\Services\User\AccessLinkService;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            UserRepositoryInterface::class,
            EloquentUserRepository::class
        );

        $this->app->bind(
            UserLinkRepositoryInterface::class,
            EloquentUserLinkRepository::class
        );

        $this->app->bind(
            GameResultRepositoryInterface::class,
            EloquentGameResultRepository::class
        );

        $this->app->bind(
            CacheServiceInterface::class,
            RedisCacheService::class
        );

        $this->app->when(AccessLinkService::class)
            ->needs(CacheServiceInterface::class)
            ->give(function ($app) {
                return $app->make(UserLinkRedisCacheService::class);
            });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Route::bind('token', function ($value) {
            $cacheService = $this->app->make(UserLinkRedisCacheService::class);
            if (!$cacheService->has(new UserLink(['token' => $value]))) {
                $userLink = UserLink::where('token', $value)->firstOrFail();
                $cacheService->put($userLink);
            } else {
                $userLink = $cacheService->get(new UserLink(['token' => $value]));
            }
            return $userLink;
        });

        JsonResource::withoutWrapping();
    }
}
