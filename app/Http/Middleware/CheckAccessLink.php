<?php

namespace App\Http\Middleware;

use App\Models\UserLink;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAccessLink
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->route('token');
        if ($token->isExpired()) {
            abort(404, __('messages.access_link_expired'));
        }
        return $next($request);
    }
}
