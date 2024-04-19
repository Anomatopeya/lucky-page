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

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getPhone(): int
    {
        return $this->phone;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }
}
