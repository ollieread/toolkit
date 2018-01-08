<?php

namespace Ollieread\Toolkit\Validators;

use Illuminate\Contracts\Validation\Factory;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;

/**
 * Base Validator
 *
 * Allows for simple model/object based validation.
 *
 * @package Ollieread\Toolkit\Validators
 */
abstract class BaseValidator
{
    /**
     * @var \Illuminate\Contracts\Validation\Validator
     */
    protected $validator;

    /**
     * @var array
     */
    protected $data = [];

    /**
     * @var \Illuminate\Database\Eloquent\Model|null
     */
    protected $model = null;

    /**
     * @param array                                    $data
     * @param \Illuminate\Database\Eloquent\Model|null $model
     */
    public function __construct(array $data, ?Model $model = null)
    {
        $this->data  = $data;
        $this->model = $model;
    }

    /**
     * @param array                                    $data
     * @param \Illuminate\Database\Eloquent\Model|null $model
     *
     * @return static
     * @throws \Illuminate\Validation\ValidationException
     */
    public static final function validate(array $data, ?Model $model = null)
    {
        $validator = new static($data, $model);
        $validator->fire();

        return $validator;
    }

    /**
     * Retrieve an array of rules.
     *
     * @return array
     */
    public abstract function getRules(): array;

    /**
     * Returns the data.
     * Override this method to handle it yourself.
     *
     * @return array
     */
    protected function getData(): array
    {
        return $this->data;
    }

    /**
     * Retrieve an array of custom messages for the validator.
     * Override this method to handle it yourself.
     *
     * @return array
     */
    public function getMessages(): array
    {
        return [];
    }

    /**
     * This validator instance.
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public final function validator(): Validator
    {
        return $this->validator;
    }

    /**
     * Handles failure.
     * Override this method to handle it yourself.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failed()
    {
        throw new ValidationException($this->validator);
    }

    /**
     * Trigger validation
     *
     * @return bool
     * @throws ValidationException
     */
    private function fire()
    {
        $this->validator = app(Factory::class)->make($this->getData(), $this->getRules(), $this->getMessages());

        if ($this->validator->fails()) {
            $this->failed();
        }

        return true;
    }
}