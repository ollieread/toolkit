<?php
namespace Ollieread\Toolkit\Eloquent\Enabled;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Ollieread\Toolkit\Eloquent\Scope;

class EnabledScope extends Scope
{
    protected $extensions = [
        'Disabled', 'Enabled', 'WithDisabled'
    ];

    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $builder
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        if ($model instanceof EnabledContract) {
            $builder->where($model->getEnabledColumn(), '=', 1);
        }
    }

    protected function addDisabled(Builder $builder)
    {
        $builder->macro('disabled', function (Builder $builder) {
            return $builder->where($builder->getModel()->getEnabledColumn(), '=', 0);
        });
    }

    protected function addEnabled(Builder $builder)
    {
        $builder->macro('enabled', function (Builder $builder) {
            return $builder->where($builder->getModel()->getEnabledColumn(), '=', 1);
        });
    }

    protected function addWithDisabled(Builder $builder)
    {
        $builder->macro('withDisabled', function (Builder $builder) {
            return $builder->withoutGlobalScope($this);
        });
    }
}