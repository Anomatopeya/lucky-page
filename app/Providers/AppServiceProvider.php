<?php

namespace App\Providers;

use App\Models\UserLink;
use App\Repositories\Game\EloquentGameResultRepository;
use App\Repositories\Game\GameResultRepositoryInterface;
use App\Repositories\User\EloquentUserLinkRepository;
use App\Repositories\User\EloquentUserRepository;
use App\Repositories\User\UserLinkRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
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
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Route::bind('token', function ($value) {
            return UserLink::where('token', $value)->firstOrFail();
        });

        JsonResource::withoutWrapping();
    }
}
