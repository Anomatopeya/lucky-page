<?php

namespace Tests\Unit\Services\User;

use App\Models\UserLink;
use App\Services\User\AccessLinkService;
use App\Repositories\User\UserLinkRepositoryInterface;
use App\Http\Dto\UserLinkDto;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class AccessLinkServiceTest extends TestCase
{

    public function testSaveAccessLinkReturnsToken()
    {
        $mockRepository = $this->createMock(UserLinkRepositoryInterface::class);
        $mockRepository->method('create')->willReturn('test_token');

        $service = new AccessLinkService($mockRepository);

        $linkDto = new UserLinkDto(1, 'test_token', now());

        $this->assertEquals('test_token', $service->saveAccessLink($linkDto));
    }

    public function testSaveAccessLinkCallsRepositoryCreateOnce()
    {
        $mockRepository = $this->createMock(UserLinkRepositoryInterface::class);
        $mockRepository->expects($this->once())->method('create');

        $service = new AccessLinkService($mockRepository);

        $linkDto = new UserLinkDto(1, 'test_token', now());

        $service->saveAccessLink($linkDto);
    }

    public function testUpdateAccessLink()
    {
        $userLinkRepository = $this->createMock(UserLinkRepositoryInterface::class);
        $accessLinkService = new AccessLinkService($userLinkRepository);
        $oldToken = generateRandomToken();
        $newToken = generateRandomToken();

        $userLink = new UserLink();
        $userLink->user_id = 1;
        $userLink->token = $oldToken;

        $newLinkDto = new UserLinkDto($userLink->user_id, $newToken, Carbon::now()->addDays(1));

        DB::shouldReceive('transaction')->andReturnUsing(function ($callback) use ($userLink) {
            return $callback();
        });

        $userLinkRepository->expects($this->once())->method('deactivate')->with($oldToken);
        $userLinkRepository->expects($this->once())->method('create')->with($newLinkDto)->willReturn($newToken);

        $result = $accessLinkService->updateAccessLink($userLink, $newLinkDto);

        $this->assertEquals($newToken, $result);
    }


    public function testDeactivateAccessLink()
    {
        $userLinkRepository = $this->createMock(UserLinkRepositoryInterface::class);
        $accessLinkService = new AccessLinkService($userLinkRepository);
        $oldToken = generateRandomToken();

        $userLink = new UserLink();
        $userLink->token = $oldToken;

        $userLinkRepository->expects($this->once())->method('deactivate')->with($userLink->token);

        $accessLinkService->deactivateAccessLink($userLink);

        $this->assertTrue(true);
    }
}
