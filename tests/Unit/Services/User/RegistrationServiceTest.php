<?php

namespace Tests\Unit\Services\User;

use App\Http\Dto\UserDto;
use App\Models\User;
use App\Repositories\User\UserRepositoryInterface;
use App\Services\User\RegistrationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Mockery;

class RegistrationServiceTest extends TestCase
{
    use RefreshDatabase;
    public function tearDown(): void
    {
        Mockery::close();
    }


    public function testCreateNewUserSuccessfully()
    {
        $userRepository = Mockery::mock(UserRepositoryInterface::class);
        $userDto = new UserDto( 'John Doe',12312312312);
        $user = new User(['name' => 'John Doe', 'phone' => 12312312312]);


        $userRepository->shouldReceive('create')->once()->with($userDto)->andReturn($user);

        $registrationService = new RegistrationService($userRepository);
        $result = $registrationService->createNewUser($userDto);


        $this->assertInstanceOf(User::class, $result);
        $this->assertEquals($user, $result);
    }
}
