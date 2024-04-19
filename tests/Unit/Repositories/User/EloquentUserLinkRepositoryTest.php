<?php

namespace Tests\Unit\Repositories\User;

use App\Http\Dto\UserLinkDto;
use App\Models\User;
use App\Models\UserLink;
use App\Repositories\User\EloquentUserLinkRepository;
use Tests\TestCase;

class EloquentUserLinkRepositoryTest extends TestCase
{

    public function testFindReturnsUserLinkWhenTokenExists()
    {
        $userLink = UserLink::factory()->create();
        $repository = new EloquentUserLinkRepository();

        $foundUserLink = $repository->find($userLink->token);

        $this->assertEquals($userLink->token, $foundUserLink->token);
    }

    public function testFindThrowsExceptionWhenTokenDoesNotExist()
    {
        $this->expectException(\Illuminate\Database\Eloquent\ModelNotFoundException::class);

        $repository = new EloquentUserLinkRepository();
        $repository->find('nonexistenttoken');
    }


    public function testFindActiveReturnsUserLinkWhenTokenExistsAndIsActive()
    {
        $userLink = UserLink::factory()->state(['expires_at' => now()->addDay()])->create();

        $repository = new EloquentUserLinkRepository();

        $foundUserLink = $repository->findActive($userLink->token);

        $this->assertEquals($userLink->token, $foundUserLink->token);
    }

    public function testFindActiveThrowsExceptionWhenTokenDoesNotExistOrIsNotActive()
    {
        $this->expectException(\Illuminate\Database\Eloquent\ModelNotFoundException::class);

        $repository = new EloquentUserLinkRepository();
        $repository->findActive('nonexistenttoken');
    }


    public function testCreateCreatesAndReturnsToken()
    {
        $testToken = generateRandomToken();
        $user = User::factory()->create();
        $dto = new UserLinkDto($user->id, $testToken , now()->addDay());
        $repository = new EloquentUserLinkRepository();

        $token = $repository->create($dto);

        $this->assertDatabaseHas('user_links', [
            'user_id' => $user->id,
            'token' => $testToken,
        ]);
        $this->assertEquals($testToken, $token);
    }

    public function testDeleteDeletesAndReturnsSuccess()
    {
        $userLink = UserLink::factory()->create();
        $repository = new EloquentUserLinkRepository();

        $success = $repository->delete($userLink->token);

        $this->assertEquals(1, $success);
        $this->assertDatabaseMissing('user_links', ['token' => $userLink->token]);
    }


    public function testDeactivateDeactivatesAndReturnsSuccess()
    {
        $userLink = UserLink::factory()->state(['expires_at' => now()->addDay()])->create();
        $repository = new EloquentUserLinkRepository();

        $success = $repository->deactivate($userLink->token);

        $this->assertEquals(1, $success);
        $this->assertDatabaseHas('user_links', [
            'token' => $userLink->token,
            'expires_at' => now(),
        ]);
    }
}
