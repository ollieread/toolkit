<?php
namespace Ollieread\Toolkit;

use Illuminate\Auth\TokenGuard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Ollieread\MultitenancyOld\Auth\Guard\SessionGuard;
use Ollieread\MultitenancyOld\Auth\Provider\DatabaseUserProvider;
use Ollieread\MultitenancyOld\Auth\Provider\EloquentUserProvider;
use Ollieread\Toolkit\Repositories\BaseRepository;

/**
 * Version Service Provider
 *
 * @package Ollieread\Version
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