<?php

namespace Ollieread\Toolkit\Query\Expressions;

use Illuminate\Database\Query\Expression;

class GroupConcat extends Expression
{
    public function __construct($value)
    {
        parent::__construct(strpos($value, '.') === 0 ? '`' . $value . '`' : $value);
    }

    public function getValue()
    {
        return 'GROUP_CONCAT(' . parent::getValue() . ')';
    }
}