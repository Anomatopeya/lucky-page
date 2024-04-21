<?php

namespace Tests\Unit\Repositories\Game;

use App\Http\Dto\GameResultDto;
use App\Models\GameResult;
use App\Models\User;
use App\Repositories\Game\EloquentGameResultRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EloquentGameResultRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private EloquentGameResultRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = new EloquentGameResultRepository();
    }

    public function testGetGameScoresWithLimitReturnsCorrectResults()
    {
        $userId = User::factory()->create()->id;
        $gameResults = GameResult::factory()->count(5)->create(['user_id' => $userId]);

        $results = $this->repository->getGameScoresWithLimit($userId);

        $this->assertEquals($gameResults->sortByDesc('created_at')->values()->take(GameResult::HISTORY_LIST_LIMIT)->toArray(), $results->toArray());
    }

    public function testGetGameScoresWithLimitReturnsEmptyCollectionForNonExistentUser()
    {
        $results = $this->repository->getGameScoresWithLimit(999);

        $this->assertTrue($results->isEmpty());
    }

    public function testSaveGameScoreCreatesNewGameResult()
    {
        $userId = User::factory()->create()->id;
        $dto = new GameResultDto(100, true, 200);

        $this->repository->saveGameScore($userId, $dto);

        $this->assertDatabaseHas('game_results', [
            'user_id' => $userId,
            'score' => $dto->getScore(),
            'is_win' => $dto->isWin(),
            'win_amount' => $dto->getWinAmount(),
        ]);
    }
}
