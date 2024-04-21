<?php

namespace App\Http\Controllers;

use App\Http\Dto\UserLinkDto;
use App\Http\Resources\GameResultResource;
use App\Models\GameResult;
use App\Models\UserLink;
use App\Services\CacheService\CacheServiceInterface;
use App\Services\Game\GameService;
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

    public function playGame(UserLink $userLink, GameService $gameService)
    {
        $gameResult = $gameService->playGame();
        //TODO: change saveResult through queue for better performance
        $gameService->saveResult($userLink->user_id, $gameResult);

        return GameResultResource::make(new GameResult([
            'score' => $gameResult->getScore(),
            'is_win' => $gameResult->isWin(),
            'win_amount' => $gameResult->getWinAmount(),
            'user_id' => $userLink->user_id,
        ]));
    }

    public function history(UserLink $userLink, GameService $gameService)
    {
        return GameResultResource::collection($gameService->getGameResults($userLink->user_id));
    }
}
