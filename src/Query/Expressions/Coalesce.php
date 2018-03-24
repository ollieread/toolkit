<?php

namespace Ollieread\Toolkit\Query\Expressions;

use Illuminate\Database\Query\Expression;

class Coalesce extends Expression
{
    /**
     * @var array
     */
    protected $values = [];

    public function __construct(...$values)
    {
        parent::__construct('');
        $this->values = $values;
    }

    public function getValue()
    {
        $value = '';

        foreach ($this->values as $values) {
            $value .= (string) $values . ',';
        }

        return 'COALESCE(' . substr($value, 0, -1) . ')';
    }
}