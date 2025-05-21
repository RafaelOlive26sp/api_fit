<?php

namespace App\Providers;

use App\Services\Query\ClasseQueryService;
use Illuminate\Support\ServiceProvider;

class QueryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(UserQueryService::class);
        $this->app->singleton(StudentQueryService::class);
        $this->app->singleton(ClasseQueryService::class);

    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
