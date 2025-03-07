<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Ticket;
use App\Models\Employee_manage_tickets;
use App\Models\Manage_chat;
use App\Events\MessageSent;

class ChatController extends Controller
{
    public function index()
    {
      $data[] = '';
      return view('chat.chat', $data);
    }
	public function shared_chat()
    {
      $data[] = '';
      return view('chat.index', $data);
    }
    public function ticket_chat()
    {
      $data[] = '';
	  //$ticketArray[] = '';
	  $user = Auth::user();
	 
	  $ticketData = Employee_manage_tickets::select('ticket_id')->where('emp_id',$user->id)->get();
		if($ticketData->count()>0)
		{
			foreach($ticketData as $ticket)
			{
				$ticketArray[] = Ticket::where('id',$ticket->ticket_id)->first();
				 
			}
		}
		$data['tickets'] = $ticketArray;
		return view('chat.ticket-chat', $data);
    }
	public function ticket_chat_list(Request $request)
	{
		$data = [];
		$ticketInfo = Ticket::where('id',$request->ticket_id)->first();
		$data['tickets'] = Ticket::where('id',$request->ticket_id)->first();
		$html = view('chat.ticket-chat-list', $data)->render();
		return response()->json([
			'success' => true,
			'name' => $ticketInfo->name,
			'email' => $ticketInfo->email,
			'phone' => $ticketInfo->phone,
			'html' => $html,
		]);
	}
	public function ticket_send_message(Request $request)
	{
		//echo $request->ticket_id.' '.$request->message_content; die;
		$model = Ticket::find($request->ticket_id);
		//echo $model->name.''.$model->email;die;
		$model->name = $model->name;
		$model->email = $model->email;
		$model->phone = $model->phone;
		$model->department = $model->department;
		$model->message_reply = $request->message_content;
		$model->updated_at = now();
		$model->save();
		
		//--- send mail ----
		$to_mail = $model->email;
		$patientname = $model->name;
		$get_email = get_email(6);
		if(!empty($get_email))
		{
			$data = [
				'subject' => $get_email->message_subject,
				'body' => str_replace(array("[NAME]", "[MESSAGE]"), array($patientname, $request->message_content), $get_email->message),
				'toEmails' => [$to_mail],
			];
			send_email($data);
		}
		
		
		return response()->json([
			'success' => true,
			'ticket_id' => $request->ticket_id,
		]);
	}
	// chat patient real time 
	public function chatPage(Request $request)
	{
		$receiverId = $request->query('receiverId'); // Get from URL

		//\Log::info('Receiver ID from URL:', ['receiverId' => $receiverId]); // Debug

		$chatUsers = Manage_chat::where('receiver_id', auth()->id())
			->orWhere('sender_id', auth()->id())
			->with(['sender', 'receiver'])
			->orderBy('created_at', 'desc')
			->get()
			->groupBy(function ($message) {
				return $message->sender_id == auth()->id() ? $message->receiver_id : $message->sender_id;
			});

		// If no receiverId is set, pick the first available user
		if (!$receiverId && $chatUsers->isNotEmpty()) {
			//\Log::info('Receiver ID was not found, setting to first user.');
			$receiverId = $chatUsers->keys()->first();
		}

		// Debugging: Check if `$receiverId` is correctly assigned
		//\Log::info('Final Receiver ID:', ['receiverId' => $receiverId]);

		// Load messages for selected user
		$messages = collect();
		/*if ($receiverId) {
			$messages = Manage_chat::where(function ($query) use ($receiverId) {
				$query->where('sender_id', auth()->id())
					->where('receiver_id', $receiverId);
			})->orWhere(function ($query) use ($receiverId) {
				$query->where('sender_id', $receiverId)
					->where('receiver_id', auth()->id());
			})->orderBy('created_at', 'asc')->get();
		}*/
		if (!empty($receiverId)) {
			$messages = Manage_chat::where(function ($query) use ($receiverId) {
					$query->where('sender_id', auth()->id())
						->where('receiver_id', $receiverId);
				})
				->orWhere(function ($query) use ($receiverId) {
					$query->where('sender_id', $receiverId)
						->where('receiver_id', auth()->id());
				})
				->orderBy('id', 'asc')
				->get();
			//echo '<pre>';print_r($messages);die;
		}

		return view('chat.chat', compact('messages', 'chatUsers', 'receiverId'));
	}

	/*public function chatPage(Request $request)
	{
		$receiverId = $request->query('receiverId'); // Get from URL
		//$receiverId = 16; // Get from URL

		$chatUsers = Manage_chat::where('receiver_id', auth()->id())
			->orWhere('sender_id', auth()->id())
			->with(['sender', 'receiver'])
			->orderBy('created_at', 'desc')
			->get()
			->groupBy(function ($message) {
				return $message->sender_id == auth()->id() ? $message->receiver_id : $message->sender_id;
			});

		// If no receiverId is set, pick the first available user
		if (!$receiverId && $chatUsers->isNotEmpty()) {
			$receiverId = $chatUsers->keys()->first();
		}

		// Load messages for selected user
		$messages = collect();
		if ($receiverId) {
			$messages = Manage_chat::where(function ($query) use ($receiverId) {
				$query->where('sender_id', auth()->id())
					->where('receiver_id', $receiverId);
			})->orWhere(function ($query) use ($receiverId) {
				$query->where('sender_id', $receiverId)
					->where('receiver_id', auth()->id());
			})->orderBy('created_at', 'asc')->get();
		}

		return view('chat.chat', compact('messages', 'chatUsers', 'receiverId'));
	}*/


	/*public function chatPage($receiverId = null)
	{
		// Get all users who have chatted with the logged-in user
		$chatUsers = Manage_chat::where('receiver_id', auth()->id())
			->orWhere('sender_id', auth()->id())
			->with(['sender', 'receiver']) // Ensure relationships exist in the Manage_chat model
			->orderBy('created_at', 'desc')
			->get()
			->groupBy(function ($message) {
				return $message->sender_id == auth()->id() ? $message->receiver_id : $message->sender_id;
			});

		// If a receiver is selected, fetch chat messages
		$messages = collect();
		if ($receiverId) {
			$messages = Manage_chat::where(function ($query) use ($receiverId) {
				$query->where('sender_id', auth()->id())
					->where('receiver_id', $receiverId);
			})->orWhere(function ($query) use ($receiverId) {
				$query->where('sender_id', $receiverId)
					->where('receiver_id', auth()->id());
			})->orderBy('created_at', 'desc')->get();
		}
		
		//echo "<pre>";print_r($messages);die;
		return view('chat.chat', compact('chatUsers', 'messages', 'receiverId'));
	}*/

	
	/*public function chatPage($receiverId='')
    {
		$chatUsers = Manage_chat::where('receiver_id', auth()->id())
        ->orWhere('sender_id', auth()->id())
        ->with(['sender', 'receiver'])
        ->orderBy('created_at', 'desc')
        ->get()
        ->groupBy(function ($message) {
            return $message->sender_id == auth()->id() ? $message->receiver_id : $message->sender_id;
        });

       return view('chat.chat', compact('messages', 'chatUsers','receiverId'));
    }
	public function chatWithUser($receiverId)
	{
		$messages = Manage_chat::where(function ($query) use ($receiverId) {
			$query->where('sender_id', auth()->id())
				->where('receiver_id', $receiverId);
		})->orWhere(function ($query) use ($receiverId) {
			$query->where('sender_id', $receiverId)
				->where('receiver_id', auth()->id());
		})->orderBy('created_at', 'asc')->get();

		return view('chat.chat', compact('messages', 'receiverId'));
	}*/

    public function sendMessage(Request $request)
    {
		$chat_group_id = substr(sha1(mt_rand()),17,6);
        $message = Manage_chat::create([
            'source' => 0,
            'user_type' => 1,
            'chat_group_id' => $chat_group_id,
            'sender_id' => auth()->id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
            'is_read' => 1,
            'created_at' => date('Y-m-d h:i:s'),
        ]);
			
		broadcast(new MessageSent($message))->toOthers();
        return response()->json($message);
    }
}
