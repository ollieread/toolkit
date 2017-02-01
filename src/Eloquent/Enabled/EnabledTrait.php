<?php
namespace Ollieread\Toolkit\Eloquent\Enabled;

trait EnabledTrait
{

    protected $enabled = 'active';

    public function getEnabledColumn()
    {
        return $this->enabled;
    }

    /**
     * Boot the trait for a model.
     *
     * @return void
     */
    public static function bootEnabledTrait()
    {
        static::addGlobalScope(new EnabledScope());
    }
}