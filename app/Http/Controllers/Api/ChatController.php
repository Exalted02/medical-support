<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use App\Models\Manage_chat;
use App\Models\Chat_reason;
use App\Models\User;

use Carbon\Carbon;

class ChatController extends Controller
{
    public function chat_reason_list()
    {
        $reasons = Chat_reason::where('status', 1)->get(['id', 'reason']);
        return response()->json([
            'success' => true,
            'data' => $reasons
        ]);
    }
	public function chats_list()
	{
		$data = [];
		$login_user_id = Auth::guard('sanctum')->user()->id;
		
		$chats = Manage_chat::where(function ($query) use($login_user_id) {
				$query->where('sender_id', $login_user_id)
					  ->orWhere('receiver_id', $login_user_id);
			})->get()->groupBy('chat_group_id');
		
		foreach($chats as $k=>$chats_data){
			$chats = $chats_data[0];
			$sender = User::where('id', $chats->receiver_id)->first();
			$issue = Chat_reason::where('id', $chats->reason)->first();
			
			$data[] = [
				'ticket_number' => $k,
				'resident' => '',
				'timestamp' => Carbon::parse($chats->created_at ?? '')->format('M j Y g:iA'),
				'issue' => $issue->reason ?? '',
				'assigned_to' => $sender->name ?? '',
			];
		}
		return response()->json([
            'success' => true,
            'data' => $data
        ]);
	}
}