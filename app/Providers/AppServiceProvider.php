<?php

namespace App\Providers;

use App\Services\RickAndMortyApiService\CharacterApiServiceInterface;
use App\Services\RickAndMortyApiService\RickAndMortyApiService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            CharacterApiServiceInterface::class,
            RickAndMortyApiService::class,

        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::preventLazyLoading();
    }
}
