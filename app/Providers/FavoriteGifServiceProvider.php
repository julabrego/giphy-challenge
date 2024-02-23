<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\Services\GiphyAPIService;
use App\Http\Services\FavoriteGifService;
use App\Repositories\FavoriteGifRepository;

class FavoriteGifServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(FavoriteGifService::class, function ($app) {
            return new FavoriteGifService($app->make(FavoriteGifRepository::class), $app->make(GiphyAPIService::class));
        });
    }
    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
    }
}
