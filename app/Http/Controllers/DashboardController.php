<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Manage_chat;
use App\Models\Chat_reason;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

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
			})->with('chat_feedback_status')->get()->groupBy('chat_group_id');
		// dd($data['chats_data']);
		return view('client_dashboard', $data);
	}
	public function start_new_chat()
	{
		$data = [];
		$data['chat_reasons'] = Chat_reason::whereIn('user_id', [Auth::id(), 1])->where('status', 1)->get()->groupBy('group_value');
		return view('client_chat_reason', $data);
	}
	public function add_new_reason(Request $request)
	{
		$data = [];
		$request->validate([
            'reason' => 'required'
        ]);
		
		$chk_reason = Chat_reason::whereIn('user_id', [Auth::id(), 1])->where('reason', $request->reason)->first();
		if($chk_reason){
			return response()->json([
                'errors' => [
                    'reason' => ['This reason already exists.']
                ]
            ], 422);
		}
		
		$reason = new Chat_reason();
		$reason->user_id = Auth::id();
		$reason->reason = $request->reason;
		if($reason->save()){
			echo 'success';
		}else{
			echo 'error';
		}
		//echo json_encode($data);
	}
	public function add_new_other_reason(Request $request)
	{
		$data = [];
		$request->validate([
            'other_reason' => 'required'
        ],[
			'other_reason' => 'Please type reason'
		]);
		
		/*$chk_reason = Chat_reason::whereIn('user_id', [Auth::id(), 1])->where('reason', $request->other_reason)->first();
		if($chk_reason){
			return response()->json([
                'errors' => [
                    'reason' => ['This reason already exists.']
                ]
            ], 422);
		}*/
		
		$reason = new Chat_reason();
		$reason->user_id = Auth::id();
		$reason->reason = $request->other_reason;
		$reason->status = 0;
		if($reason->save()){
			return response()->json([
				'status' => 200,
				'reason_id' => $reason->id,
				'chat_url' => route('open-new-chat', [$reason->id, auth()->user()->id.time()])
			]);
		}else{
			return response()->json([
				'status' => 400
			]);
		}
		
		echo json_encode($data);
	}
}
