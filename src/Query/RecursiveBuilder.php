<?php

namespace Ollieread\Toolkit\Query;

use Illuminate\Database\Query\Builder;

class RecursiveBuilder
{
    public function recursive(string $name, \Closure $closure)
    {
        /**
         * @var Builder $this
         */
        $this->bindings['recursive'] = [];
        $recursive                   = $this->newQuery();
        //$recursive->grammar          = new BaseMySqlGrammar();
        call_user_func($closure, $recursive);
        $this->recursives[] = [$name, $recursive];
        $this->addBinding($recursive->getBindings(), 'recursive');
        $this->grammar = new MysqlGrammar();

        return $this;
    }
}