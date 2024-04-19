<?php

namespace Tests\Unit\Repositories\User;

use App\Http\Dto\UserDto;
use App\Models\User;
use App\Repositories\User\EloquentUserRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Mockery;

class EloquentUserRepositoryTest extends TestCase
{
    use RefreshDatabase;
    public function tearDown(): void
    {
        Mockery::close();
    }

    public function testFindUserSuccessfully()
    {
        $userRepository = new EloquentUserRepository();

        $user = User::factory()->create();

        $result = $userRepository->find($user->id);

        $this->assertInstanceOf(User::class, $result);
        $this->assertEquals($user->id, $result->id);
    }

    public function testFindUserWithInvalidId()
    {
        $userRepository = new EloquentUserRepository();

        $this->expectException(\Illuminate\Database\Eloquent\ModelNotFoundException::class);

        $userRepository->find(9999);
    }

    public function testCreateUserSuccessfully()
    {
        $userRepository = new EloquentUserRepository();
        $userDto = new UserDto('John Doe', 12345678901);

        $result = $userRepository->create($userDto);

        $this->assertInstanceOf(User::class, $result);
        $this->assertEquals($userDto->getName(), $result->name);
        $this->assertEquals($userDto->getPhone(), $result->phone);
    }

    public function testUpdateUserSuccessfully()
    {
        $userRepository = new EloquentUserRepository();
        $user = User::factory()->create();
        $userDto = new UserDto('Jane Doe', 1098765432);

        $result = $userRepository->update($user, $userDto);

        $this->assertTrue($result);
        $this->assertEquals($userDto->getName(), $user->name);
        $this->assertEquals($userDto->getPhone(), $user->phone);
    }

    public function testDeleteUserSuccessfully()
    {
        $userRepository = new EloquentUserRepository();
        $user = User::factory()->create();

        $result = $userRepository->delete($user);

        $this->assertTrue($result);
    }
}
