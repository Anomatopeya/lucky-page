<?php

namespace App\Repositories\User;

use App\Http\Dto\UserDto;
use App\Models\User;

/**
 * Interface UserRepositoryInterface
 *
 * This interface defines the contract for the User repository. Any class that implements
 * this interface must provide the methods defined below.
 *
 * @package App\Repositories\User
 */
interface UserRepositoryInterface
{
    /**
     * Find a User by its ID.
     *
     * @param $id
     * @return User The User, if found, or 404.
     */
    public function find($id): User;

    /**
     * Create a new User.
     *
     * @param UserDto $dto The data transfer object containing the data for the new User.
     * @return User The newly created User.
     */
    public function create(UserDto $dto): User;

    /**
     * Update an existing User.
     *
     * @param User $user The User to update.
     * @param UserDto $dto The data transfer object containing the updated data for the User.
     * @return bool
     */
    public function update(User $user, UserDto $dto): bool;

    /**
     * Delete a User.
     *
     * @param User $user The User to delete.
     * @return bool
     */
    public function delete(User $user): bool;
}
