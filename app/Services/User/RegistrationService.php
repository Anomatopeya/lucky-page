<?php

namespace App\Services\User;

use App\Http\Dto\UserDto;
use App\Models\User;
use App\Repositories\User\UserRepositoryInterface;

class RegistrationService
{
    protected UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param UserDto $dto
     * @return User
     */
    public function createNewUser(UserDto $dto): User
    {
        return $this->userRepository->create($dto);
    }

}
