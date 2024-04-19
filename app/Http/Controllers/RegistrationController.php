<?php

namespace App\Http\Controllers;

use App\Http\Dto\UserLinkDto;
use App\Http\Requests\RegistrationRequest;
use App\Services\User\AccessLinkService;
use App\Services\User\RegistrationService;
use Carbon\Carbon;

class RegistrationController extends Controller
{
    public function __invoke(RegistrationRequest $request, RegistrationService $service, AccessLinkService $accessLinkService)
    {
        $user = $service->createNewUser($request->getDto());
        $linkDto = new UserLinkDto($user->id, generateRandomToken(), Carbon::now()->addDays(config('app.link_expiration')));
        $token = $accessLinkService->saveAccessLink($linkDto);
        return view('registration.success', ['token' => $token]);
    }
}
