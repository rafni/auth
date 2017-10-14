<?php

namespace Rafni\Auth\Repositories\Users;

use Rafni\Auth\Traits\ValidateAbleTrait as ValidateAble;
use Rafni\Auth\Repositories\Users\User;
use Rafni\Auth\Repositories\Users\UsersContract;

/**
 * Class UsersService
 * @package Rafni\Auth\Repositories\Users
 */
class UsersService implements UsersContract
{
    use ValidateAble;
    
    /**
     * @var array
     */
    protected $validationCreateRules = [
        'display_name'  => 'required|string|max:40',
        'email'         => 'required|string|email|max:255|unique:users',
        'password'      => 'string|min:6|confirmed',
    ];

    /**
     * @var array
     */
    protected $validationUpdateRules = [
        'display_name'  => 'required|string|max:40',
        'email'         => 'required|string|email|max:255|unique:users',
        'password'      => 'string|min:6|confirmed',
    ];

    /**
     * @var array
     */
    protected $validationMessages = [

    ];

    /**
     * @var User
     */
    protected $model;

    /**
     * @var array
     */
    protected $includes = [];

    /**
     * UsersService constructor.
     * @param User $model
     */
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    /**
     * @param int $limit
     * @return mixed
     */
    public function get($limit = 10)
    {
        $model = $this->model->with($this->includes);
        if (!empty($limit)) {
            return $model->paginate($limit);
        }
        return $model->get();
    }

    /**
     * @param int|string $id
     * @return User
     */
    public function find($id)
    {
        return $this->model->findOrFail($id);
    }

    /**
     * @param array $attributes
     * @return User
     * @throws ValidationException
     */
    public function create(array $attributes = [])
    {
        $this->runValidator($attributes, $this->validationCreateRules, $this->validationMessages);
        $this->model->fill($attributes);
        $this->model->password = bcrypt($this->model->password);
        $this->model->enabled_access = false;
        $this->model->save();
        return $this->model;
    }

    /**
     * @param int|string $id
     * @param array $attributes
     * @return User
     * @throws ValidationException
     */
    public function update($id, array $attributes = [])
    {
        $model = $this->find($id);
        $rules = $this->validationUpdateRules;
        $rules['email'] .= ',email,'.$model->id;
        
        $this->runValidator($attributes, $rules, $this->validationMessages);
        $model->fill($attributes);
        $model->save();
        return $model->fresh();
    }

    /**
     * @param int|string $id
     * @return bool
     */
    public function delete($id)
    {
        $model = $this->find($id);
        return $model->delete();
    }
}