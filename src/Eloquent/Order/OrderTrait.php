<?php
namespace Ollieread\Toolkit\Eloquent\Order;


trait OrderTrait
{

    protected $order = 'order';

    public function getOrderColumn()
    {
        return $this->order;
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