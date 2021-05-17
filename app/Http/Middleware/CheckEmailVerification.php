<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckEmailVerification
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user();
        $is_verified = $user->hasVerifiedEmail();
        if(!$is_verified){
            $request->merge(array("not_verified" => "not_verified"));
        }
        return $next($request);  

    }
}
