<?php

namespace App\Repositories\Game;

use App\Http\Dto\GameResultDto;
use App\Models\GameResult;
use Illuminate\Database\Eloquent\Collection;

class EloquentGameResultRepository implements GameResultRepositoryInterface
{
    /**
     * @param int $userId
     * @return Collection
     */
    public function getGameScoresWithLimit(int $userId): Collection
    {
        return GameResult::query()->where('user_id', $userId)->latest()->limit(GameResult::HISTORY_LIST_LIMIT)->get();
    }

    /**
     * @param int $userId
     * @param GameResultDto $dto
     * @return void
     */
    public function saveGameScore(int $userId, GameResultDto $dto): void
    {
        GameResult::create([
            'user_id' => $userId,
            'score' => $dto->getScore(),
            'is_win' => $dto->isWin(),
            'win_amount' => $dto->getWinAmount(),
        ]);
    }
}
