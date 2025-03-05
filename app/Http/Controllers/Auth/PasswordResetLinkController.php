<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;
use Illuminate\Support\Str;
use App\Models\User;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
	public function store(Request $request)
	{
		
		$request->validate([
			'email' => ['required', 'email', 'exists:users,email'],
		], [
			'email.exists' => 'The email address is not registered in our system.',
		]);
		
		$token = Str::random(64);
		User::where('email',$request->email)->update(['token'=>$token]);
		
		$get_email = get_email(3);
		
		$resetLink = url('reset-password/' . $token);
		$link = "<a href='{$resetLink}'>Reset Password</a>";
		$data = [
				'subject' => $get_email->message_subject,
				'body' => str_replace(array("[LINK]"), array($link), $get_email->message),
				'toEmails' => [$request->email],
			];
		send_email($data);
		
		return redirect()->route('password.request')->with('status','Link send to your mail..');
	}
    public function store_bck(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);
		

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = Password::sendResetLink(
            $request->only('email')
        );
		
        return $status == Password::RESET_LINK_SENT
                    ? back()->with('status', __($status))
                    : back()->withInput($request->only('email'))
                            ->withErrors(['email' => __($status)]);
    }
}
