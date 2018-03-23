<?php

namespace Ollieread\Toolkit\Query;

use Illuminate\Database\Query\Builder;
use Illuminate\Database\Query\Grammars\MySqlGrammar as BaseGrammar;

class MysqlGrammar extends BaseGrammar
{

    /**
     * The components that make up a select clause.
     *
     * @var array
     */
    protected $selectComponents = [
        'recursives',
        'aggregate',
        'columns',
        'from',
        'joins',
        'wheres',
        'groups',
        'havings',
        'orders',
        'limit',
        'offset',
        'lock',
    ];

    protected function compileRecursives(Builder $query, $recursives)
    {
        return collect($recursives)->map(function ($recursive) use ($query) {
            return trim("WITH RECURSIVE {$this->wrapTable($recursive[0])} AS ({$recursive[1]->toSql()})");
        })->implode(' ');
    }

    protected function compileComponents(Builder $query)
    {
        $sql = [];

        foreach ($this->selectComponents as $component) {
            // To compile the query, we'll spin through each component of the query and
            // see if that component exists. If it does we'll just call the compiler
            // function for the component which is responsible for making the SQL.
            if (property_exists($query, $component) && null !== $query->$component) {
                $method = 'compile'.ucfirst($component);

                $sql[$component] = $this->$method($query, $query->$component);
            }
        }

        return $sql;
    }
}