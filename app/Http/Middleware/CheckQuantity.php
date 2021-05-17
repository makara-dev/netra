<?php

namespace App\Http\Middleware;

use Closure;

class CheckQuantity
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
        if($request->has('quantity'))
        {
            $quantity = (int) $request->input('quantity');
            if ($quantity > 0) {
                return $next($request);
            }
            return back()->with('error', 'Invalid quantity');
        }
        return back()->with('error', 'No product found');
    }
}
