<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\Controllers\GiphyAPIController;
use App\Http\Adapters\GiphyAPIAdapter;
use App\Http\Services\GiphyAPIService;

class GiphyAPIServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(GiphyAPIService::class, function ($app) {
            return new GiphyAPIService(config('app.giphy.api_key'));
        });
        $this->app->singleton(GiphyAPIAdapter::class, function ($app) {
            return new GiphyAPIAdapter($app->make(GiphyAPIService::class));
        });

        $this->app->singleton(GiphyAPIController::class, function ($app) {
            return new GiphyAPIController($app->make(GiphyAPIAdapter::class));
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
    }
}
