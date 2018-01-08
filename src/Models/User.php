<?php
namespace Ollieread\Toolkit\Models;

use Illuminate\Foundation\Auth\User as BaseUser;
use Illuminate\Support\Facades\Hash;

/**
 * Extends the base auth user model.
 *
 * Only difference right now is that it has a mutator for the password attribute
 * so that we don't have to manually hash. Everyone messes that up now and
 * again.
 *
 * @package Ollieread\Toolkit\Models
 */
abstract class User extends BaseUser
{

    /**
     * Mutator for setting the password. Saves manually hashing.
     *
     * @param string $value
     */
    public function setPasswordAttribute(string $value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    /**
     * Checks whether the password matches that of the user.
     *
     * @param $value
     *
     * @return mixed
     */
    public function isPassword(string $value) : boolean
    {
        return Hash::check($value, $this->attributes['password']);
    }
}