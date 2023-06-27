<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Laravel\Socialite\Facades\Socialite;

class TwitchAuthController extends Controller
{
    //

    public function redirect() 
    {
        $redirect = Socialite::driver('twitch')->redirect();

        return Inertia::location($redirect);
    }

    public function callback() 
    {
        $user = Socialite::driver('twitch')->user();
        \Log::debug('user', [$user]);
         
        $finduser = User::where('twitch_id', $user->id)->first();
     
        if($finduser){
     
            $finduser->update([
                'email' => $user->email,
                'name' => $user->name,
                'avatar' => $user->avatar,
            ]);

            Auth::login($finduser);
        }else{
            $newUser = User::updateOrCreate(['email' => $user->email],[
                    'name' => $user->name,
                    'twitch_id'=> $user->id,
                    'password' => encrypt('123456dummy'),
                    'avatar' => $user->avatar,
                ]);
     
            Auth::login($newUser);
        }

        return redirect()->intended('dashboard');
    }
}
