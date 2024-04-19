<?php

namespace App\Repositories\User;

use App\Http\Dto\UserLinkDto;
use App\Models\UserLink;

class EloquentUserLinkRepository implements UserLinkRepositoryInterface
{

    public function find(string $token)
    {
        return UserLink::whereToken($token)->firstOrFail();
    }


    public function findActive(string $token)
    {
        return UserLink::where('token', $token)
            ->where('expires_at', '>', now())
            ->firstOrFail();
    }

    public function create(UserLinkDto $dto): string
    {
        return UserLink::create([
            'user_id' => $dto->getUserId(),
            'token' => $dto->getToken(),
            'expires_at' => $dto->getExpiredAt(),
        ])->token;
    }

    public function delete(string $token)
    {
        return UserLink::whereToken($token)->delete();
    }

    public function deactivate(string $token)
    {
        return UserLink::whereToken($token)->update(['expires_at' => now()]);
    }

}
