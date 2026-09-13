<?php

namespace Seotarek\LlmRouter;

use Illuminate\Support\ServiceProvider;
use Seotarek\LlmRouter\Services\RouterService;

class LlmRouterServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/llm-router.php', 'llm-router');

        $this->app->singleton('llm-router', function ($app) {
            return new RouterService($app['config']['llm-router']);
        });
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/llm-router.php' => config_path('llm-router.php'),
            ], 'llm-router-config');
        }
    }
}
