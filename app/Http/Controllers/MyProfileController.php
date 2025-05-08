<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class MyProfileController extends Controller
{
    public function index()
    {
		$user = Auth::user();	 
		
		$data['userData'] = User::where('id',$user->id)->first();
		return view('my-profile.index', $data);
    }
    public function my_profile_submit(Request $request)
    {
		// dd($request->all());
		$request->validate([
			'first_name'=>'required',
			'last_name'=>'required',
			'phone_full'=>'required',
		], [], [
			'phone_full' => 'contact number',
		]);
		
		$user = Auth::user();	 
		$user->first_name = $request->post('first_name');
		$user->last_name = $request->post('last_name');
		$user->phone_number = $request->post('phone_full');
		$user->save();
		
		return redirect()->back()->with('success', 'Profile updated successfully.');
    }
}
