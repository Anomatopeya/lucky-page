<?php

namespace Tests\Unit\Services\User;

use App\Services\User\AccessLinkService;
use App\Repositories\User\UserLinkRepositoryInterface;
use App\Http\Dto\UserLinkDto;
use PHPUnit\Framework\TestCase;

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
}
