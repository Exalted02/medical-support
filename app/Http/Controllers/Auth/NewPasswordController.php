<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Models\User;

class NewPasswordController extends Controller
{
    /**
     * Display the password reset view.
     */
    public function create(Request $request): View
    {
        return view('auth.reset-password', ['request' => $request]);
    }

    /**
     * Handle an incoming new password request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
		$request->validate([
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
			'token' => ['required'],
        ]);
		
		$user = User::where('token',$request->token)->first();
        $user->forceFill([
                'password' => Hash::make($request->password),
                'remember_token' => Str::random(60), // Update remember token
            ])->save();

            event(new PasswordReset($user));
		
		/*$status = Password::reset(
			$request->only('password', 'password_confirmation', 'token', 'email'), // Include email in request
			function ($user, $password) {
				$user->forceFill([
					'password' => Hash::make($password),
					'remember_token' => Str::random(60), // Update remember token
				])->save();

				event(new PasswordReset($user));
			}
		);
		
		return $status == Password::PASSWORD_RESET
                    ? redirect()->route('login')->with('status', __($status))
                    : back()->withInput($request->only('email'))
                            ->withErrors(['email' => __($status)]);*/
							
		return redirect()->route('login')->with('status', 'Your password has been reset successfully.');
    }
}
