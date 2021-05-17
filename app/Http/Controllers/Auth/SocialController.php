<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Customer;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use Gloudemans\Shoppingcart\Facades\Cart;

class SocialController extends Controller
{
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider)
    {
        $getInfo = Socialite::driver($provider)->user();

        $user = $this->createUser($getInfo, $provider);

        auth()->login($user, true);

        //restore their guest cart
        $customerId = $user->customer->customer_id;
        Cart::restore($customerId);

        return redirect()->route('home')->with('status', 'Login successfully');;
    }

    function createUser($getInfo, $provider)
    {
        $user = User::where('email', $getInfo->email)->first();

        if (!$user) { //user havent registered

            $user = User::create([
                'name'     => $getInfo->name,
                'email'    => $getInfo->email,
                'provider' => $provider,
                'provider_id' => $getInfo->id,
            ]);
            $user->markEmailAsVerified();

            //make user as customer
            $result = $user->customer()->save(new Customer());
            if (!$result) {
                abort(500, 'Something went wrong during registration.');
            }
            //store their guest cart
            Cart::store($result->customer_id);

        } else { //user already registed with email
            $user->provider = $provider;
            $user->provider_id = $getInfo->id;
            $user->save();
        }

        return $user;
    }
}
