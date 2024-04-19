<?php

namespace App\Providers;

use App\Repositories\User\EloquentUserLinkRepository;
use App\Repositories\User\EloquentUserRepository;
use App\Repositories\User\UserLinkRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
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
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
