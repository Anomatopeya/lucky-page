<?php

namespace App\Repositories\User;

use App\Http\Dto\UserLinkDto;
use App\Models\UserLink;

/**
 * Interface UserLinkRepositoryInterface
 *
 * This interface defines the contract for the User Link repository. Any class that implements
 * this interface must provide the methods defined below.
 *
 * @package App\Repositories\User
 */
interface UserLinkRepositoryInterface
{
    /**
     * Find a User Link by its token.
     *
     * @param string $token The token of the User Link to find.
     * @return UserLink The User Link, if found, or null.
     */
    public function find(string $token): UserLink;

    /**
     * Find an active User Link by its token.
     *
     * @param string $token The token of the User Link to find.
     * @return UserLink The User Link, if found and active, or null.
     */
    public function findActive(string $token): UserLink;

    /**
     * Create a new User Link.
     *
     * @param UserLinkDto $dto The data transfer object containing the data for the new User Link.
     * @return string The token of the newly created User Link.
     */
    public function create(UserLinkDto $dto): string;

    /**
     * Delete a User Link.
     *
     * @param string $token The token of the User Link to delete.
     * @return int The number of User Links deleted.
     */
    public function delete(string $token): int;

    /**
     * Deactivate a User Link.
     *
     * @param string $token The token of the User Link to deactivate.
     * @return int The number of User Links deactivated.
     */
    public function deactivate(string $token): int;
}
