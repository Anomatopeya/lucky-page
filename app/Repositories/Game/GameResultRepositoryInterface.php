<?php

namespace App\Repositories\Game;

use App\Http\Dto\GameResultDto;
use Illuminate\Database\Eloquent\Collection;

interface GameResultRepositoryInterface
{
    /**
     * @param int $userId
     * @return Collection
     */
    public function getGameScoresWithLimit(int $userId):Collection;

    /**
     * @param int $userId
     * @param GameResultDto $dto
     * @return void
     */
    public function saveGameScore(int $userId, GameResultDto $dto): void;
}
