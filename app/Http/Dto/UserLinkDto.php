<?php

namespace App\Http\Dto;

use Carbon\Carbon;

class UserLinkDto
{
    private int $userId;

    private string $token;

    private Carbon $expiredAt;

    public function __construct(int $userId, string $token, Carbon $expiredAt)
    {
        $this->userId = $userId;
        $this->token = $token;
        $this->expiredAt = $expiredAt;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function getExpiredAt(): Carbon
    {
        return $this->expiredAt;
    }
}
