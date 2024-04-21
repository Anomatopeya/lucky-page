<?php

namespace App\Services\Game;

use App\Http\Dto\GameResultDto;
use App\Repositories\Game\GameResultRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class GameService
{
    private GameResultRepositoryInterface $gameResultRepository;

    public function __construct(GameResultRepositoryInterface $gameResultRepository)
    {
        $this->gameResultRepository = $gameResultRepository;
    }

    public function playGame(): GameResultDto
    {
        $gameScore = $this->getGameScore();
        $isWin = $this->isWinGame($gameScore);
        $winAmount = $isWin ? $this->calculateWinAmount($gameScore) : 0;
        return new GameResultDto($gameScore, $isWin, $winAmount);
    }

    public function saveResult(int $userId, GameResultDto $gameResult): void
    {
        $this->gameResultRepository->saveGameScore($userId, $gameResult);
    }

    public function getGameResults(int $userId): Collection
    {
        return $this->gameResultRepository->getGameScoresWithLimit($userId);
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
