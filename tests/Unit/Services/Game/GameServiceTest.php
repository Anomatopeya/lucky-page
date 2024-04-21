<?php

namespace Tests\Unit\Services\Game;

use App\Http\Dto\GameResultDto;
use App\Models\User;
use App\Repositories\Game\GameResultRepositoryInterface;
use App\Services\Game\GameService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class GameServiceTest extends TestCase
{
    use RefreshDatabase;

    private $repository;
    private $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = Mockery::mock(GameResultRepositoryInterface::class);
        $this->service = new GameService($this->repository);
    }

    public function testGameCanBePlayed()
    {
        $result = $this->service->playGame();

        $this->assertInstanceOf(GameResultDto::class, $result);
    }

    public function testGameResultCanBeSaved()
    {
        $userId = User::factory()->create()->id;
        $dto = new GameResultDto(100, true, 200);

        $this->repository->shouldReceive('saveGameScore')->with($userId, $dto)->once();

        $this->service->saveResult($userId, $dto);

        $this->assertTrue(true);
    }

    public function testGameResultsCanBeRetrieved()
    {
        $userId = User::factory()->create()->id;

        $this->repository->shouldReceive('getGameScoresWithLimit')->with($userId)->once();

        $results = $this->service->getGameResults($userId);

        $this->assertIsIterable($results);
    }
}
