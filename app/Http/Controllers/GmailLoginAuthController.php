<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Providers\RouteServiceProvider;

class GmailLoginAuthController extends Controller
{
    public function redirectToGoogleLogin($type)
    {
		session(['google_login_role' => $type]);
		// dd(config('services.google_login'));
		return Socialite::driver('google')->redirect();
        /*return Socialite::driver('google')
            ->setConfig(config('services.google_login'))
			->stateless()
            ->redirect();*/
    }
	public function handleGoogleLoginCallback()
    {
        try {
			$googleUser = Socialite::driver('google')->user();
            /*$googleUser = Socialite::driver('google')
                ->setConfig(config('services.google_login'))
                ->stateless()
                ->user();*/
			// dd($googleUser);
			
			$type = session('google_login_role');
			$get_existing = User::where('email', $googleUser->getEmail())->first();
			if($get_existing){
				if($get_existing->user_type != $type){
					if($get_existing->user_type == 1){
						$reg_as = 'employee';
					}else{
						$reg_as = 'client';
					}
					return redirect('/login')->with('error', 'You already registered as '.$reg_as.'.');
				}
			}
			
            $user = User::updateOrCreate([
                'email' => $googleUser->getEmail(),
                'user_type' => $type,
            ], [
                'name' => $googleUser->getName(),
                'auth_provider' => 1,
                'auth_provider_id' => $googleUser->getId(),
                'password' => Hash::make('12345678'),
            ]);

            Auth::login($user);

            $log_user = Auth::user();

			if ($log_user->user_type == 1) {
				// dd(RouteServiceProvider::EMPLYHOME);
				return redirect()->intended(RouteServiceProvider::EMPLYHOME);
			} elseif ($log_user->user_type == 2) {
				// dd(RouteServiceProvider::CLIENTHOME);
				return redirect()->intended(RouteServiceProvider::CLIENTHOME);
			}
			
			return redirect()->intended(RouteServiceProvider::HOME);
        } catch (\Exception $e) {
			//dd($e->getMessage());
            return redirect('/login')->with('error', $e->getMessage());
        }
    }
}
