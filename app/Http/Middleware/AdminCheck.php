<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        if (!Auth::check()) {
            return response()->json([
                'msg' => "UnAuthorized",
                'a' => Auth::check()
            ], 402);
        }
        $user = Auth::user();
        if ($user->userType == 'User') {
            return response()->json([
                'msg' => 'UnAuthorized'
            ], 402);
        }
        return $next($request);
    }
}
