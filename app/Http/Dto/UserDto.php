<?php

namespace App\Http\Dto;

class UserDto
{
    private string $name;
    private int $phone;
    private ?int $id;

    public function __construct(string $username, int $phone, ?int $id = null)
    {
        $this->name = $username;
        $this->phone = $phone;
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
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
