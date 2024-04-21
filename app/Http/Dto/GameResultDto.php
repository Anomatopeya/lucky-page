<?php

namespace App\Http\Dto;

class GameResultDto
{
    private int $score;
    private bool $isWin;
    private float $winAmount;

    public function __construct(int $score, bool $isWin, float $winAmount)
    {
        $this->score = $score;
        $this->isWin = $isWin;
        $this->winAmount = $winAmount;
    }

    public function getScore(): int
    {
        return $this->score;
    }

    public function isWin(): bool
    {
        return $this->isWin;
    }

    public function getWinAmount(): float
    {
        return $this->winAmount;
    }
}
