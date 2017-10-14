<?php

namespace Rafni\Auth\Repositories\Users;

/**
 * Class UsersContract
 * @package Rafni\Auth\Repositories\Users
 */
interface UsersContract
{
    /**
     * @param int $limit
     * @return mixed
     */
    public function get($limit = 10);

    /**
     * @param int|string $id
     * @return User
     */
    public function find($id);

    /**
     * @param array $attributes
     * @return User
     */
    public function create(array $attributes = []);

    /**
     * @param int|string $id
     * @param array $attributes
     * @return User
     */
    public function update($id, array $attributes = []);

    /**
     * @param int|string $id
     * @return bool
     */
    public function delete($id);
}