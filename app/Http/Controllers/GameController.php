<?php

namespace App\Http\Controllers;

use App\Http\Dto\UserLinkDto;
use App\Models\UserLink;
use App\Services\User\AccessLinkService;
use Carbon\Carbon;

class GameController extends Controller
{
    public function getPage(UserLink $userLink)
    {
        $userLink->load('user');

        return view('game', [
            'user' => $userLink->user,
            'userLink' => $userLink,
        ]);
    }

    public function generateNewLink(UserLink $userLink, AccessLinkService $accessLinkService)
    {
        $token = $accessLinkService->updateAccessLink(
            $userLink,
            new UserLinkDto(
                $userLink->user_id,
                generateRandomToken(),
                Carbon::now()->addDays(config('app.link_expiration'))
            )
        );

        return json_encode(['url' => route('lucky-page', $token)]);
    }

    public function deactivateLink(UserLink $userLink, AccessLinkService $accessLinkService)
    {
        $accessLinkService->deactivateAccessLink($userLink);

        return json_encode(['url' => route('homepage')]);
    }
}
