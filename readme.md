# Laravel Toolkit #

[![Latest Stable Version](https://poser.pugx.org/ollieread/laravel-toolkit/v/stable.png)](https://packagist.org/packages/ollieread/laravel-toolkit) [![Total Downloads](https://poser.pugx.org/ollieread/laravel-toolkit/downloads.png)](https://packagist.org/packages/ollieread/laravel-toolkit) [![Latest Unstable Version](https://poser.pugx.org/ollieread/laravel-toolkit/v/unstable.png)](https://packagist.org/packages/ollieread/laravel-toolkit) [![License](https://poser.pugx.org/ollieread/laravel-toolkit/license.png)](https://packagist.org/packages/ollieread/laravel-toolkit)

- **Laravel**: 5.5
- **PHP**: 7.1+
- **Author**: Ollie Read 
- **Author Homepage**: http://ollieread.com

This toolkit aims to simplify the day to day development of Laravel applications.
It has some basic functionality and modifications that I find myself using in almost
every project.

## Versions

Version | PHP | Laravel |
:-------|:----|:--------|
v1 | >= 5.6.4 | 5.3 |
v2 | >= 5.6.4 | 5.4 |
< v3.2 | >= 7.1 | 5.4 |
=> v3.2 | >= 7.1 | 5.5+ |

## Installation

Package is available on [Packagist](https://packagist.org/packages/ollieread/laravel-toolkit), you can install it using Composer.

    composer require ollieread/laravel-toolkit

## Usage

There are four pieces of functionality offered by this toolkit.

### Eloquent

This toolkit provides two different scopes, packaged up. Please note, these only provided
additional functionality to aid you, you have to handle the database schema side yourself.

#### Enabled

If you have a model that has an enabled/active state, you can add this functionality
by using the following contract and trait.

    Ollieread\Toolkit\Eloquent\Enabled\EnabledContract
    Ollieread\Toolkit\Eloquent\Enabled\EnabledTrait
    
Adding these to your model will automatically add the following scope.

    Ollieread\Toolkit\Eloquent\Enabled\EnabledScope
    
Your enable state column must be a boolean/int field. If it is called anything but `enabled`
you can override the property provided by the trait.

    protected $enabled = 'enabled';
    
Once all of this has been added, querying this model will only return the enabled entries by
default. To return all, use the following method, much like soft deletes.

    withDisabled()
    
If you only want disabled, use the following.

    disabled()
    
#### Order

If you have a model that is orderable, you can add this functionality by adding the following
trait and contract to your model.

    Ollieread\Toolkit\Eloquent\Order\OrderContract
    Ollieread\Toolkit\Eloquent\Order\OrderTrait
    
This will add the following global scope.

    Ollieread\Toolkit\Eloquent\Order\OrderScope
    
Your queries will now be ordered by the order field, the name of which is provided
by overriding the property provided by the trait. This column must be an integer.

    protected $order = 'order';
    
You can change the order of a given model by using the following self explanatory macros.

    moveUp()
    moveDown()
    moveToTop()
    moveToBottom()
    
Moving a row up, down, to the top or to the bottom, will correct the order value for all other rows.
The values of the column will be numeric, with the top being 0.

### Base Validator

The base validator is a step away from Form Requests. This is primarily due to my dislike of having the HTTP layer validate data, which is not its job.

To create a validator, extend the following class;

    Ollieread\Toolkit\Validators\BaseValidator
    
Next you define your rules with the following method;

    public function getRules(): array {
        return [];
    }
    
You can also optionally override the following method, to provide custom messages;

    public function getMessages(): array {
        return [];
    }
    
To validate your data, you can do the following;

    $myValidator = MyValidator::validate($arrayOfData[, $model])
    
The second argument allows you to pass in a model (useful when validating update forms). This model is available within the `getRules()` and `getMessages()` methods as `$this->model`.

A Laravel validation exception is thrown automatically should validation fail.

To return an instance of the underlying validator you can do the following;

    $myValidator->validator();

### Base Repository

The base repository is an abstract class that I have all of my repositories extend. This repository by default is designed to work with Eloquent.

To create a repository, extend the following class;

    Ollieread\Toolkit\Repositories\BaseRepository
    
To set the model for your repository, add the following property;

    property $model = MyModel::class;

#### Make (protected)

To retrieve a new instance of your model, call the following;

    $this->make()
    
#### Query (protected)

To retrieve a new query on a new instance of your model, call the following;

    $this->query()
    
This method primarily exists as helper (calls `$this->make()->newQuery()`) so that my IDE doesn't cry at me.

#### Get ID (protected)

To retrieve the id from a variable that is either the id, or an instance of the model, call the following;

    $this->getId($id)

#### Delete

This is a base deletion method, if you pass in an ID it uses a query, if you pass in a model it calls the helper. To access it, call the following;

    $repository->delete($model)
    
#### Get One By

This a method to retrieve a single row by either a key => value, or an array of key => values, to use it, call the following;

    $repository->getOneBy($key, $value)
    $repository->getOneBy([$key1 => $value1, $key2 => $value2])
    
This method is available as a magic method, so you can do the following;

    $repository->getOneById($value)
    
#### Get By

This method is the same as the above, except it will return all matched results, rather than just one. To use it, call the following;

    $repository->getBy($key, $value)
    $repository->getBy([$key1 => $value1, $key2 => $value2])
    
This method is available as a magic method, so you can do the following;

    $repository->getByDate($value)
    
#### Transaction (static)

To start a transaction, call the following;

    MyRepository::transaction(function () {
        $this->somethingSomething();
        return true;    
    });
    
This method behaves exactly the same way as `DB::transaction()`.

### Tips

For simplicity, I like to add the method definitions to the class level phpdoc block of my repositories, like so;

    /**
     * Class MyRepository
     *
     * @method MyModel make()
     * @method null|MyModel getOneById(int $id)
     *
     * @package My\Repositories
     */

### User Model

To gain access to a password setting mutator (automatically hashes) and a helper method `isPassword($password)` to compare passwords, have your user models extend the following;

    Ollieread\Toolkit\Models\User
    
This model extends the default auth user, so you still retain that functionality.