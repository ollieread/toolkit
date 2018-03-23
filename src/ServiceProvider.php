<?php

namespace Ollieread\Toolkit;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Ollieread\Toolkit\Query\MysqlGrammar;

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
    public function boot(): void
    {
        Builder::macro('recursive', function (string $name, \Closure $closure) {
            $this->bindings['recursive'] = [];
            $recursive                   = $this->newQuery();
            call_user_func($closure, $recursive);
            $this->recursives[] = [$name, $recursive];
            $this->addBinding($recursive->getBindings(), 'recursive');
            $this->grammar = new MysqlGrammar();

            return $this;
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
    }
}