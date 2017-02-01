<?php
namespace Ollieread\Toolkit\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Scope as Contract;

abstract class Scope implements Contract
{

    /**
     * All of the extensions to be added to the builder.
     *
     * @var array
     */
    protected $extensions = [];

    /**
     * Extend the query builder with the needed functions.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @return void
     */
    public function extend(Builder $builder)
    {
        foreach ($this->extensions as $extension) {
            $this->{"add{$extension}"}($builder);
        }
    }
}