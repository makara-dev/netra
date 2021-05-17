<?php

namespace App\Http\Middleware;

use Gloudemans\Shoppingcart\Facades\Cart;
use Closure;

class CheckCart
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
        if(Cart::content()->isEmpty()){
            return redirect()->route('home')->with('error', 'Cart Empty');
        }
        return $next($request);
    }
}
