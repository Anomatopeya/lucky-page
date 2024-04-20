<?php
namespace App\Services\User;

use App\Http\Dto\UserLinkDto;
use App\Models\UserLink;
use App\Repositories\User\UserLinkRepositoryInterface;
use Illuminate\Support\Facades\DB;

class AccessLinkService
{
    protected UserLinkRepositoryInterface $userLinkRepository;

    /**
     * @param UserLinkRepositoryInterface $userLinkRepository
     */
    public function __construct(UserLinkRepositoryInterface $userLinkRepository)
    {
        $this->userLinkRepository = $userLinkRepository;
    }

    /**
     * Save access link to database and return token
     *
     * @param UserLinkDto $linkDto
     * @return string $token
     */
    public function saveAccessLink(UserLinkDto $linkDto): string
    {
        return $this->userLinkRepository->create($linkDto);
    }

    /**
     * @param UserLink $userLink
     * @param UserLinkDto $newLinkDto
     * @return string
     */
    public function updateAccessLink(UserLink $userLink, UserLinkDto $newLinkDto): string
    {
        return DB::transaction(function () use ($userLink, $newLinkDto) {
            $this->userLinkRepository->deactivate($userLink->token);
            return $this->userLinkRepository->create($newLinkDto);
        });
    }

    /**
     * @param UserLink $userLink
     * @return void
     */
    public function deactivateAccessLink(UserLink $userLink): void
    {
        $this->userLinkRepository->deactivate($userLink->token);
    }

}
