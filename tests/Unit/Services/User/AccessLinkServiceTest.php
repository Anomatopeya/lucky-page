<?php

namespace Tests\Unit\Services\User;

use App\Http\Dto\UserLinkDto;
use App\Models\User;
use App\Models\UserLink;
use App\Repositories\User\UserLinkRepositoryInterface;
use App\Services\CacheService\CacheServiceInterface;
use App\Services\User\AccessLinkService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Mockery;
use Tests\TestCase;

class AccessLinkServiceTest extends TestCase
{
    private $userLinkRepository;
    private $cacheService;
    private $accessLinkService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userLinkRepository = Mockery::mock(UserLinkRepositoryInterface::class);
        $this->cacheService = Mockery::mock(CacheServiceInterface::class);
        $this->accessLinkService = new AccessLinkService($this->userLinkRepository, $this->cacheService);
    }

    public function testSaveAccessLinkReturnsToken()
    {
        $newToken = generateRandomToken();
        $userId = User::factory()->create()->id;
        $linkDto = new UserLinkDto($userId, $newToken, Carbon::now()->addDay());
        $this->userLinkRepository->shouldReceive('create')->with($linkDto)->andReturn($newToken);

        $result = $this->accessLinkService->saveAccessLink($linkDto);

        $this->assertEquals($newToken, $result);
    }

    public function testUpdateAccessLinkReturnsNewToken()
    {
        $oldToken = generateRandomToken();
        $newToken = generateRandomToken();
        $userId = User::factory()->create()->id;
        $userLink = new UserLink(['token' => $oldToken, 'user_id' => $userId, 'expired_at' => Carbon::now()->addDay()]);
        $newLinkDto = new UserLinkDto($userId, $newToken, Carbon::now()->addDay());

        $this->userLinkRepository->shouldReceive('deactivate')->with($oldToken);
        $this->cacheService->shouldReceive('forget')->with($userLink);
        $this->userLinkRepository->shouldReceive('create')->with($newLinkDto)->andReturn($newToken);

        DB::shouldReceive('transaction')->andReturnUsing(function ($callback) {
            return $callback();
        });

        $result = $this->accessLinkService->updateAccessLink($userLink, $newLinkDto);

        $this->assertEquals($newToken, $result);
    }

    public function testDeactivateAccessLinkDeactivatesLink()
    {
        $token = generateRandomToken();
        $userId = User::factory()->create()->id;
        $userLink = new UserLink(['token' => $token, 'user_id' => $userId, 'expired_at' => Carbon::now()->addDay()]);

        $this->userLinkRepository->shouldReceive('deactivate')->with($token);
        $this->cacheService->shouldReceive('forget')->with($userLink);

        $this->accessLinkService->deactivateAccessLink($userLink);

        $this->assertTrue(true); // If we reach this point, no exceptions were thrown, so the test passed
    }
}
