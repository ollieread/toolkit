<?php

namespace Ollieread\Toolkit\Query\Expressions;

use Illuminate\Database\Query\Expression;

class Concat extends Expression
{
    protected $parts = [];

    public function __construct()
    {
        parent::__construct('');
    }

    public function addExpression(Expression $expression)
    {
        $this->parts[] = $expression;

        return $this;
    }

    public function addString(string $string)
    {
        $this->parts[] = '"' . $string . '"';

        return $this;
    }

    public function addColumn(string $column)
    {
        $this->parts[] = strpos($column, '.') === 0 ? '`' . $column . '`' : $column;

        return $this;
    }

    public function getValue()
    {
        return 'CONCAT(' . implode(',', $this->parts) .')';
    }
}