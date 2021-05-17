<?php

namespace App\Http\Middleware;

use Closure;

class IsUserNameClean
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
        if ($request->has('username')) {
            $username = $request->input('username');
            if ($this->hasIllegalCharacters($username)) {
                return back()->with('error', 
                    'User Name Input has Illegal characters / < > : " / \ | ? * \') .'
                );
            }else{
                return $next($request);
            }
        }else{
            return back()->with('status', 'No User Found.');
        }
    }
    /**
     * check username for illegal character To Use it For image File Name
     * @param  string  $username
     * @return bool $hasIllegalCharacter
     */
    private function hasIllegalCharacters($username)
    {
        $illegalCharacters = '([^\w\s\d\-_~,;\[\]\(\).])';
        $result = preg_match($illegalCharacters, $username);
        return ($result) ? true : false;
    }
}
