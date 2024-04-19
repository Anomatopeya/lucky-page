<?php

namespace App\Http\Dto;

class UserDto
{
    private string $username;
    private int $phone;
    private ?int $id;

    public function __construct(string $username, int $phone, ?int $id = null)
    {
        $this->username = $username;
        $this->phone = $phone;
        $this->id = $id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getPhone(): int
    {
        return $this->phone;
    }

    public function getId(): ?int
    {
        return $this->id;
    }
}
