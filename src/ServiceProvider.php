<?php
namespace Ollieread\Toolkit;

use Illuminate\Auth\TokenGuard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Ollieread\MultitenancyOld\Auth\Guard\SessionGuard;
use Ollieread\MultitenancyOld\Auth\Provider\DatabaseUserProvider;
use Ollieread\MultitenancyOld\Auth\Provider\EloquentUserProvider;
use Ollieread\Toolkit\Repositories\Repository;

/**
 * Version Service Provider
 *
 * @package Ollieslab\Version
 */
class ServiceProvider extends BaseServiceProvider
{

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/toolkit.php' => config_path('toolkit.php')
        ], 'config');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }

    public function registerAuth()
    {
    }
}