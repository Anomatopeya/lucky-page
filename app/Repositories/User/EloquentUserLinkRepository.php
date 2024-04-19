<?php

namespace App\Repositories\User;

use App\Http\Dto\UserLinkDto;
use App\Models\UserLink;

class EloquentUserLinkRepository implements UserLinkRepositoryInterface
{

    /**
     * @param string $token
     * @return UserLink
     */
    public function find(string $token): UserLink
    {
        return UserLink::whereToken($token)->firstOrFail();
    }

    /**
     * @param string $token
     * @return UserLink
     */
    public function findActive(string $token): UserLink
    {
        return UserLink::where('token', $token)
            ->where('expires_at', '>', now())
            ->firstOrFail();
    }

    /**
     * @param UserLinkDto $dto
     * @return string
     */
    public function create(UserLinkDto $dto): string
    {
        return UserLink::create([
            'user_id' => $dto->getUserId(),
            'token' => $dto->getToken(),
            'expires_at' => $dto->getExpiredAt(),
        ])->token;
    }

    /**
     * @param string $token
     * @return int
     */
    public function delete(string $token): int
    {
        return UserLink::whereToken($token)->delete();
    }

    /**
     * @param string $token
     * @return int
     */
    public function deactivate(string $token): int
    {
        return UserLink::whereToken($token)->update(['expires_at' => now()]);
    }

}
