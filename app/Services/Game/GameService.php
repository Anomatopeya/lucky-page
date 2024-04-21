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
        return rand(config('app.game.min_score',1), config('app.game.max_score',1000));
    }

    private function isWinGame(int $gameScore): bool
    {
        return $gameScore % 2 === 0;
    }

    private function calculateWinAmount(int $gameScore): float
    {
        $conditions = config('app.victory_conditions', []);
        foreach ($conditions as $condition) {
            if ($gameScore > $condition['score']) {
                return round($gameScore * $condition['multiplier']);
            }
        }
        return 0;
    }
}
