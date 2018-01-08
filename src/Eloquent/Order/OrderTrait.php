<?php
namespace Ollieread\Toolkit\Eloquent\Order;


trait OrderTrait
{
    public function getOrderColumn()
    {
        return 'order';
    }

    public function getOrderScope()
    {
        return null;
    }

    /**
     * Boot the trait for a model.
     *
     * @return void
     */
    public static function bootOrderTrait()
    {
        static::addGlobalScope(new OrderScope());
    }
}