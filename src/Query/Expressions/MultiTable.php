<?php

namespace Ollieread\Toolkit\Query\Expressions;

use Illuminate\Database\Query\Expression;

class MultiTable extends Expression
{
    /**
     * @var array
     */
    protected $tables = [];

    public function __construct()
    {
        parent::__construct('');
    }

    public function addTable($table)
    {
        $this->tables[] = $table;
        return $this;
    }

    public function getValue()
    {
        $value = '';

        foreach ($this->tables as $table) {
            $value .= (string) $table .', ';
        }

        return substr($value, 0, -2);
    }
}