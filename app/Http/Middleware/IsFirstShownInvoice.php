<?php

namespace App\Http\Middleware;

use Closure;

class IsFirstShownInvoice
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
        $referer = strtok($request->header('Referer'), '?');
        if($referer == url('checkout/contact')){
            return $next($request);
        }else{
            return redirect()->route('home')->with('error', 'Invalid Url');
        }
    }
}
