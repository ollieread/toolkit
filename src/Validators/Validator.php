<?php
namespace Ollieread\Toolkit\Validators;

use Illuminate\Contracts\Validation\Factory;
use Illuminate\Validation\ValidationException;

/**
 * Base Validator
 *
 * Allows for simple model/object based validation.
 *
 * @package Ollieslab\Toolkit\Validators
 */
abstract class Validator
{

    /**
     * Add the {ID} placeholder to the rules and it'll be replaced by the ID passed
     * in when running the validator.
     *
     * @var array
     */
    protected static $rules = ['create' => [], 'update' => []];

    protected static $messages = ['create' => [], 'update' => []];

    /**
     * @var \Illuminate\Validation\Factory
     */
    protected $validator;

    /**
     * @param Factory $validator
     */
    public function __construct(Factory $validator)
    {
        $this->validator = $validator;
    }

    public function __call($method, $arguments)
    {
        if (starts_with($method, 'validFor')) {
            $name = snake_case(substr($method, 8));
            if (isset(static::$messages[$name])) {
                $messages = static::$messages[$name];
            } else {
                $messages = [];
            }

            if (isset(static::$rules[$name])) {
                $rules = static::$rules[$name];
                if (isset($arguments[1]) && is_array($arguments[1])) {
                    $rules = array_merge($rules, $arguments[1]);
                }

                return $this->fire($arguments[0], $rules, $messages);
            }
        }
    }

    /**
     * Generic method
     *
     * @param String   $action   The action that define the validation. It corresponds to the array key on the Validator
     *                           file.
     * @param array    $data     Array of data to validate against.
     * @param int      $id       The ID the skip
     * @param array    $rules    Additional rules. This will also overwrite any existing rules by the same name.
     * @param array    $messages Additional messages.
     *
     * @return bool
     * @throws \Exception
     */
    public function validFor($action, array $data, integer $id = null, array $rules = [], array $messages = [])
    {
        if (!isset($action) || is_array($action) || !is_string($action)) {
            throw new \Exception('Invalid validation rulset for ' . $action);
        }

        $rules = array_key_exists($action, static::$rules) ? array_merge(static::$rules[$action], $rules) : $rules;
        $messages = array_key_exists($action, static::$messages) ? array_merge(static::$messages[$action], $messages) : $messages;

        if ($id) {
            foreach ($rules as $key => $rule) {
                if (strpos($rule, '{ID}') !== false) {
                    $rules[$key] = str_replace('{ID}', $id, $rule);
                }
            }
        }

        return $this->fire($data, $rules, $messages);
    }

    /**
     * Trigger validation
     *
     * @param array $data
     * @param array $rules
     * @param array $messages
     *
     * @return bool
     * @throws ValidationException
     */
    private function fire(array $data, array $rules = [], array $messages = [])
    {
        $validation = $this->validator->make($data, $rules, $messages);

        if ($validation->fails()) {
            throw new ValidationException($validation);
        }

        return true;
    }
}