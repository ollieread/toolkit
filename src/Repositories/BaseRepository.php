<?php

namespace Ollieread\Toolkit\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 * Base Repository
 *
 * @package Ollieslab\Toolkit\Repositories
 */
abstract class BaseRepository
{
    /**
     * @var string
     */
    protected $model;

    /**
     * @return Model
     */
    protected function make()
    {
        return new $this->model;
    }

    /**
     * Accepts either the id or model. It's a safety method so that you can just pass argument in
     * and receiver the id back.
     *
     * @param $model
     *
     * @return mixed
     */
    protected function getId($model) : int
    {
        return $model instanceof Model ? $model->getKey() : $model;
    }

    /**
     * Delete the model.
     *
     * @param $model
     *
     * @return bool|null
     */
    public function delete($model)
    {
        if ($model instanceof Model) {
            return $model->delete();
        }

        $id = $model;
        $model = $this->make();

        return $model->newQuery()->where($model->getKeyName(), $id)->delete();
    }

    /**
     * Helper method for retrieving models by a column or array of columns.
     *
     * @return mixed
     */
    public function getBy() : ?Collection
    {
        $model = $this->make();

        if (func_num_args() == 2) {
            list($column, $value) = func_get_args();
            $method = is_array($value) ? 'whereIn' : 'where';
            $model = $model->$method($column, $value);
        } elseif (func_num_args() == 1) {
            $columns = func_get_arg(0);

            if (is_array($columns)) {
                foreach ($columns as $column => $value) {
                    $method = is_array($value) ? 'whereIn' : 'where';
                    $model = $model->$method($column, $value);
                }
            }
        }

        return $model->get();
    }

    /**
     * Helper method for retrieving a model by a column or array of columns.
     *
     * @return mixed
     */
    public function getOneBy() : ?Model
    {
        $model = $this->make();

        if (func_num_args() == 2) {
            list($column, $value) = func_get_args();
            $method = is_array($value) ? 'whereIn' : 'where';
            $model = $model->$method($column, $value);
        } elseif (func_num_args() == 1) {
            $columns = func_get_args();

            if (is_array($columns)) {
                foreach ($columns as $column => $value) {
                    $method = is_array($value) ? 'whereIn' : 'where';
                    $model = $model->$method($column, $value);
                }
            }
        }

        return $model->first();
    }

    /**
     * Magic method handling for dynamic functions such as getByAddress() or getOneById().
     *
     * @param       $name
     * @param array $arguments
     *
     * @return \Illuminate\Database\Eloquent\Collection|mixed|null
     */
    function __call($name, $arguments = [])
    {
        if (count($arguments) > 1) {
            // TODO: Should probably throw an exception here
            return null;
        }

        if (substr($name, 0, 5) == 'getBy') {
            return $this->getBy(snake_case(substr($name, 5)), $arguments[0]);
        } elseif (substr($name, 0, 8) == 'getOneBy') {
            $column = snake_case(substr($name, 8));

            return call_user_func_array([$this->make(), 'where'], [$column, $arguments[0]])->first();
        }
    }

    /**
     * Perform a transaction.
     *
     * @param \Closure    $callback
     * @param int         $attempts
     * @param string|null $connection
     *
     * @return mixed
     */
    public static function transaction(\Closure $callback, int $attempts = 1, string $connection = null)
    {
        if ($connection) {
            return DB::connection($connection)->transaction($callback, $attempts);
        } else {
            return DB::transaction($callback, $attempts);
        }
    }
}