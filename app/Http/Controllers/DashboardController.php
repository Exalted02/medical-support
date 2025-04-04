<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Manage_chat;
use App\Models\Chat_reason;

class DashboardController extends Controller
{
    public function index()
    {
		$data = [];
		return view('dashboard', $data);
    }
	public function employee_dashboard()
	{
		$data = [];
		return view('employee_dashboard', $data);
	}
	public function client_dashboard()
	{
		$data = [];
		$data['chats_data'] = Manage_chat::where(function ($query) {
				$query->where('sender_id', auth()->id())
					  ->orWhere('receiver_id', auth()->id());
			})->get()->groupBy('chat_group_id');
		// dd($data['chats_data']);
		return view('client_dashboard', $data);
	}
	public function start_new_chat()
	{
		$data = [];
		$data['chat_reasons'] = Chat_reason::where('status','!=',2)->get();
		return view('client_chat_reason', $data);
	}
}
