<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class IsStaff
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $redirecturi = '/')
    {
        if(Auth::check()){
            $currentStaff = auth()->user()->staff;
            if($currentStaff != null){
                return $next($request);
            }
            return redirect()->route('home')->with('error', "Un-Authorize Request (Staffs Only)");
        }
        return redirect($redirecturi )->with('error', "Un-Authorize Request.");
    }
}
