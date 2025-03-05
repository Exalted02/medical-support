<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\Validator;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function client_create(): View
    {
        return view('auth.client-register');
    }
    public function employee_create(): View
    {
        return view('auth.employee-register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
		$validator = Validator::make($request->all(), [
			'first_name' => 'required|string|max:255',
			'last_name' => 'required|string|max:255',
			'email' => 'required|email|unique:users,email',
			'password' => 'required|min:6|confirmed',
		]);

		if ($validator->fails()) {
			return redirect()->back()->withErrors($validator)->withInput();
		}
        
        $user = User::create([
            'name' => $request->first_name .' '.$request->last_name,
            'user_type' => 1,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
	public function store_customer(Request $request)
	{
		//echo "<pre>";print_r($request->all());
		 $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirm', Rules\Password::defaults()],
        ]);
		
		$first_name  		= $request->first_name;
		$last_name  		= $request->last_name;
		$email  			= $request->email;
		$password  			= $request->password;
		$confirm_password  	= $request->confirm_password;
		$company_name  		= $request->company_name;
		$address  			= $request->address;
		$city  				= $request->city;
		$state  			= $request->state;
		$zipcode  			= $request->zipcode;
		$phone_number  		= $request->phone_number;
		$upload_tax_lisence = $request->upload_tax_lisence;
		
		$moidel = new User();
		$moidel->first_name = $request->first_name ?? null;
		$moidel->last_name = $request->last_name ?? null;
		$moidel->email = $request->email ?? null;
		$moidel->password = $request->password ?? null;
		$moidel->city = $request->city ?? null;
		$moidel->state = $request->state ?? null;
		$moidel->zipcode = $request->zipcode ?? null;
		$moidel->phone_number = $request->phone_number ?? null;
		$moidel->upload_tax_lisence = $request->upload_tax_lisenc ?? nulle;
		$moidel->save();
		
		
	}
}
