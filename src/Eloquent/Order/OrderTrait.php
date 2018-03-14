<?php
namespace Ollieread\Toolkit\Eloquent\Order;


trait OrderTrait
{
    public function getOrderColumn(): string
    {
        return 'order';
    }

    public function getOrderScope(): void
    {
        return null;
    }

    /**
     * Boot the trait for a model.
     *
     * @return void
     */
    public static function bootOrderTrait(): void
    {
        static::addGlobalScope(new OrderScope());
    }
}