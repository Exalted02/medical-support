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
use App\Models\Department;

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
		$departments = Department::all();
        return view('auth.employee-register', compact('departments'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store_employee(Request $request): RedirectResponse
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
			'username' => $request->username ?? '',
            'password' => Hash::make($request->password),
            'department' => $request->department ?? '',
        ]);

        event(new Registered($user));

        Auth::login($user);
		
		//--- send mail ----
		$resetLink = url('verify-email/' . $request->email);
		$link = "<a href='{$resetLink}'>click here</a>";
		$empname = $request->first_name .' '.$request->last_name;
		$get_email = get_email(1);
		if(!empty($get_email))
		{
			$data = [
				'subject' => $get_email->message_subject,
				'body' => str_replace(array("[EMPLOYEE_NAME]", "[EMAIL_ID]", "[PASSWORD]","[VERIFYEMAIL]"), array($empname, $request->email, $request->password, $link), $get_email->message),
				'toEmails' => [$user->email],
			];
			send_email($data);
		}
		
        return redirect(RouteServiceProvider::EMPLYHOME);
    }
	public function store_client(Request $request): RedirectResponse
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
            'user_type' => 2,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'username' => $request->username ?? '',
            'password' => Hash::make($request->password),
            'company_name' => $request->company_name ?? '',
            'phone_number' => $request->phone_number ?? '',
            'fax' => $request->fax ?? '',
        ]);

        event(new Registered($user));

        Auth::login($user);
		
		//--- send mail ----
		$resetLink = url('verify-email/' . $request->email);
		$link = "<a href='{$resetLink}'>click here</a>";
		
		$empname = $request->first_name .' '.$request->last_name;
		$get_email = get_email(2);
		if(!empty($get_email))
		{
			$data = [
				'subject' => $get_email->message_subject,
				'body' => str_replace(array("[CLIENT_NAME]", "[EMAIL_ID]", "[PASSWORD]","[VERIFYEMAIL]"), array($empname, $request->email, $request->password,$link), $get_email->message),
				'toEmails' => [$user->email],
			];
			send_email($data);
		}
		
		return redirect(RouteServiceProvider::CLIENTHOME);
	}
	public function verify_email(Request $request)
	{
		$email = $request->route('email');
		User::where('email',$email)->update(['email_verified_at'=> date('Y-m-d h:i:s')]);
		return redirect()->route('login');
	}
	
	public function store_customer(Request $request)
	{
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
