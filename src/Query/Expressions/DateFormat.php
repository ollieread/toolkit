<?php

namespace Ollieread\Toolkit\Query\Expressions;

use Illuminate\Database\Query\Expression;

class DateFormat extends Expression
{
    /**
     * @var string
     */
    protected $column;

    /**
     * @var string
     */
    protected $format;

    public function __construct(string $column, string $format)
    {
        parent::__construct('');
        $this->column = $column;
        $this->format = $format;
    }

    public function getValue()
    {
        return 'DATE_FORMAT(`' . $this->column . '`, "' . $this->format . '")';
    }
}