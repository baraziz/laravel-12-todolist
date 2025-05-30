<?php

namespace App\Providers;

use App\Repositories\TodoRepository;
use App\Repositories\TodoRepositoryImpl;
use App\Services\TodoService;
use App\Services\TodoServiceImpl;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class TodoServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(TodoRepository::class, function (Application $app) {
            return new TodoRepositoryImpl();
        });

        $this->app->singleton(TodoService::class, function (Application $app) {
            return new TodoServiceImpl($app->make(TodoRepository::class));
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
