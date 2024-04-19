<?php
namespace App\Services\User;

use App\Http\Dto\UserLinkDto;
use App\Repositories\User\UserLinkRepositoryInterface;

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

}
