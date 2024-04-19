<?php

namespace App\Repositories\User;

use App\Http\Dto\UserLinkDto;

interface UserLinkRepositoryInterface
{
    public function find(string $token);

    public function findActive(string $token);

    public function create(UserLinkDto $dto): string;

    public function delete(string $token);

    public function deactivate(string $token);

}
