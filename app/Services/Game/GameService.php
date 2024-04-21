<?php

namespace App\Services\Game;

use App\Http\Dto\GameResultDto;

class GameService
{
    public function playGame(): GameResultDto
    {
        $gameScore = $this->getGameScore();
        $isWin = $this->isWinGame($gameScore);
        $winAmount = $isWin ? $this->calculateWinAmount($gameScore) : 0;
        $resultDto = new GameResultDto($gameScore, $isWin, $winAmount);
        return $resultDto;
    }

    private function getGameScore(): int
    {
        return rand(1, 1000);
    }

    private function isWinGame(int $gameScore): bool
    {
        return $gameScore % 2 === 0;
    }

    private function calculateWinAmount(int $gameScore): float
    {
        if ($gameScore > 900) {
            return round($gameScore * 0.7);
        }

        if ($gameScore > 600) {
            return round($gameScore * 0.5);
        }

        if ($gameScore > 300) {
            return round($gameScore * 0.3);
        }

        return round($gameScore * 0.1);
    }
}
