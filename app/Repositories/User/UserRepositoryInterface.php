<?php

namespace App\Repositories\User;

use App\Http\Dto\UserDto;
use App\Models\User;

interface UserRepositoryInterface
{
    public function find($id);

    /**
     * @param UserDto $dto
     * @return User
     */
    public function create(UserDto $dto): User;

    public function update(User $user, UserDto $dto);

    public function delete(User $user);
}
