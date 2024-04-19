<?php

namespace App\Repositories\User;

use App\Http\Dto\UserDto;
use App\Models\User;

class EloquentUserRepository implements UserRepositoryInterface
{
    /**
     * @param $id
     * @return User
     */
    public function find($id): User
    {
        return User::where('id', $id)->firstOrFail();
    }

    /**
     * @param UserDto $dto
     * @return User
     */
    public function create(UserDto $dto): User
    {
        return User::create([
            'name' => $dto->getUsername(),
            'phone' => $dto->getPhone(),
        ]);
    }

    /**
     * @param User $user
     * @param UserDto $dto
     * @return bool
     */
    public function update(User $user, UserDto $dto): bool
    {
        return $user->update([
            'name' => $dto->getUsername(),
            'phone' => $dto->getPhone(),
        ]);
    }

    /**
     * @param User $user
     * @return bool|null
     */
    public function delete(User $user): ?bool
    {
        return $user->delete();
    }
}
