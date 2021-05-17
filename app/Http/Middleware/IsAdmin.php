<?php

namespace App\Http\Middleware;

use Closure;
use Exception;

class IsAdmin
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
        //try catch block for non-staff user
        try{
            $currentUser = auth()->user()->staff;
            if ($currentUser->is_admin){
                return $next($request);
            }
            return redirect($redirecturi)->with('Error', "Un-Authorize Request.Only Admin Can Access Here");
        }catch(Exception $e){
            return redirect($redirecturi)->with('Error', "Un-Authorize Request.Only Admin Can Access Here");
        }
    }
}
