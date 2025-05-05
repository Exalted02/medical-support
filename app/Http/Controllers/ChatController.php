<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Ticket;
use App\Models\Employee_manage_tickets;
use App\Models\Manage_chat;
use App\Models\Manage_chat_file;
use App\Models\Chat_reason;
use App\Events\MessageSent;
use App\Events\MessageUpdated;
use App\Events\MessageDeleted;
use App\Models\Department;
use App\Models\User;
use App\Models\Chat_feedback_status;
use Illuminate\Support\Facades\Validator; 

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
	  $ticketArray = [];
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
		$cg_id = $request->query('chatGroup'); // Get from URL
		
		//\Log::info('Receiver ID from URL:', ['receiverId' => $receiverId]); // Debug

		/*$chatUsers = Manage_chat::where('receiver_id', auth()->id())
			->orWhere('sender_id', auth()->id())
			->with(['sender', 'receiver'])
			->orderBy('created_at', 'desc')
			->get()
			->groupBy(function ($message) {
				return $message->sender_id == auth()->id() ? $message->receiver_id : $message->sender_id;
			});*/
		$chatUsers = Manage_chat::where(function ($query) {
				$query->whereRaw("FIND_IN_SET(?, receiver_id)", [auth()->id()])
					->orWhereRaw("FIND_IN_SET(?, sender_id)", [auth()->id()]);
				})
				->with(['sender', 'receiver'])
				->orderBy('created_at', 'desc')
				->get()
				->groupBy('chat_group_id');
				/*->groupBy(function ($message) {
					return in_array(auth()->id(), explode(',', $message->sender_id)) 
						? $message->receiver_id 
						: $message->sender_id;
				});*/	
		// dd($chatUsers);	
		if (!$receiverId && $chatUsers->isNotEmpty()) {
			//\Log::info('Receiver ID was not found, setting to first user.');
			$receiverId = $chatUsers->keys()->first();
			
		}
		
		$chat_group_id = '';
		$receiverName = '';
		$receiverEmail = '';
		$receiverPhone = '';
		$receiverDepartment = '';
		$receiverDepartment = User::where('id',auth()->user()->id)->first()->department;
		
		$messages = collect();
		
		if (!empty($receiverId) && !empty($cg_id)) {
			/*$messages = Manage_chat::where(function ($query) use ($receiverId) {
					$query->where('sender_id', auth()->id())
						->where('receiver_id', $receiverId);
				})
				->orWhere(function ($query) use ($receiverId) {
					$query->where('sender_id', $receiverId)
						->where('receiver_id', auth()->id());
				})
				->orderBy('id', 'asc')
				->get();*/
			$messages = Manage_chat::where(function ($query) use ($receiverId, $cg_id) {
					$query->where('chat_group_id', $cg_id);
					$query->whereRaw("FIND_IN_SET(?, sender_id)", [auth()->id()])
						  ->whereRaw("FIND_IN_SET(?, receiver_id)", [$receiverId]);
				})
				->orWhere(function ($query) use ($receiverId, $cg_id) {
					$query->where('chat_group_id', $cg_id);
					$query->whereRaw("FIND_IN_SET(?, sender_id)", [$receiverId])
						  ->whereRaw("FIND_IN_SET(?, receiver_id)", [auth()->id()]);
				})
				->orderBy('id', 'asc')
				->get();	
			// dd($messages);	
			// $chat_group_id = $messages[0]->chat_group_id ?? null;
			$chat_group_id = $cg_id ?? null;
			
			$userData = User::where('id',$receiverId)->first();
			$receiverName = $userData->name;
			$receiverEmail = $userData->email;
			$receiverPhone = $userData->phone_number;
			$receiverDepartment = $userData->department;
		}
		return view('chat.chat', compact('messages', 'chatUsers', 'receiverId','chat_group_id','receiverName','receiverEmail','receiverPhone','receiverDepartment'));
	}

	public function sendMessage(Request $request)
    {
		// dd($request->all());
		/*$request->validate([
			'files.*' => 'file|max:2048', // Max 2MB per file
		]);*/
		$validator = Validator::make($request->all(), [
			'files.*' => 'file|max:2048|mimes:jpg,jpeg,png,gif,pdf,doc,docx,xls,xlsx,ppt,pptx,txt,zip,rar', 
		]);
		
		if ($request->hasFile('files')) {
			foreach ($request->file('files') as $file) {
				$mimeType = $file->getMimeType(); // Get MIME type

				if (str_starts_with($mimeType, 'audio/') || str_starts_with($mimeType, 'video/')) {
					return response()->json([
						'status' => 'error',
						'message' => 'Audio and video files are not allowed.'
					], 422);
				}
			}
		}
		
		if ($validator->fails()) {
			return response()->json([
				'status' => 'error',
				'message' => 'Only images, PDFs, Word, Excel, PowerPoint, TXT, ZIP, and RAR files are allowed. File size should not exceed 2MB.'
			], 422);
		}
		
		$uploadedFiles = [];
		$files = '';
		if ($request->hasFile('files')) {
			foreach ($request->file('files') as $file) {
				// Define the destination path inside the public folder
				$destinationPath = public_path('uploads/chat-files');
				
				// Ensure the directory exists
				if (!file_exists($destinationPath)) {
					mkdir($destinationPath, 0777, true);
				}

				// Generate a unique file name
				$fileName = time() . '_' . $file->getClientOriginalName();
				
				// Move file to public/uploads/chat-files
				$file->move($destinationPath, $fileName);
				
				// Save the file path for further use
				if (!in_array('uploads/chat-files/' . $fileName, $uploadedFiles)) {
					$uploadedFiles[] = 'uploads/chat-files/' . $fileName;
				}
			}
		}
		
		//$chat_group_id = substr(sha1(mt_rand()),17,6);
		$edit_id = $request->edit_id;
		if($edit_id!='')
		{
			$message = Manage_chat::find($edit_id);
			$message->message = $request->message;
			$message->save();
			//broadcast(new MessageUpdated($message))->toOthers();
			event(new MessageUpdated($message));
		}
		else
		{
			/*$exists = Manage_chat::where(function ($query) {
				$query->whereRaw("FIND_IN_SET(?, receiver_id)", [auth()->id()])
					->orWhereRaw("FIND_IN_SET(?, sender_id)", [auth()->id()]);
			})->exists();*/
			$chat_group_id = $request->chat_group_id;
			$first_chat = Manage_chat::where('chat_group_id', $request->chat_group_id)->first();
			$receiver_id = $request->receiver_id;
			$userType = User::where('id',$receiver_id)->first()->user_type;
			$my_id = auth()->id();
			$userArray = explode(',', $first_chat->receiver_id); // Convert to array
			
			// Reorder: put $my_id first, remove it from its original place
			$userArray = array_values(array_filter($userArray, function ($id) use ($my_id) {
				return $id != $my_id;
			}));
			
			
			array_unshift($userArray, $my_id); // Prepend $my_id
			
			$reordered = implode(',', $userArray); // Convert back to string
			// dd($exists);	
			/*if($exists)
			{
				$receiver_id = $request->receiver_id;
				$chatData = Manage_chat::where(function ($query) use ($request) {
				$query->where('sender_id', auth()->id())
					  ->where('receiver_id', $request->receiver_id);
				})
				->orWhere(function ($query) use ($request) {
					$query->where('sender_id', $request->receiver_id)
						  ->where('receiver_id', auth()->id());
				})
				->first();
				
				$userType = User::where('id',$receiver_id)->first()->user_type;
			}
			else
			{
				$receiver_id = assignChatReceiverId($request->department_id);
				
				$chatData = Manage_chat::where(function ($query) use ($receiver_id) {
				$query->where('sender_id', auth()->id())
					  ->where('receiver_id', $receiver_id);
				})
				->orWhere(function ($query) use ($receiver_id) {
					$query->where('sender_id', $receiver_id)
						  ->where('receiver_id', auth()->id());
				})
				->first();
				
				$userType = User::where('id',$receiver_id)->first()->user_type;
			}*/
			
			
			/*if($chatData && !empty($chatData->chat_group_id))
			{
				$chat_group_id =  $chatData->chat_group_id;
			}
			else	
			{
				//echo '3';die;
				//$chat_group_id = substr(sha1(mt_rand()),17,6);
				$chat_group_id = generate_chat_unique_id(Manage_chat::class,'chat_group_id', $receiver_id);
			}*/
			
			//$userType = User::where('id',$receiver_id)->first()->user_type;
			
			$message = Manage_chat::create([
				'source' => 0,
				'user_type' => $userType,
				'reason' => $request->reason_id ?? null,
				'chat_group_id' => $chat_group_id,
				'sender_id' => $reordered,
				'receiver_id' => $receiver_id,
				'message' => $request->message,
				'is_read' => 0,
				'created_at' => date('Y-m-d h:i:s'),
			]);
			
			
			foreach($uploadedFiles as $file)
			{
				$file_type = 0;
				$extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
				if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'])) {
					//echo "Image file: " . $file->getClientOriginalName();
					$file_type = 1;
				}
				
				$files = Manage_chat_file::create([
					'manage_chat_id' => $message->id,
					'chat_group_id' => $message->chat_group_id,
					'file_type' => $file_type,
					'file_name' => $file,
					'created_at' => date('Y-m-d h:i:s'),
				]);
			}
			//broadcast(new MessageSent($message))->toOthers();
			broadcast(new MessageSent($message,$uploadedFiles))->toOthers();
			
			/*return response()->json([
				'status' => 'success',
				'message' => 'Message sent successfully.'
			]);*/
		}
    }
	public function sendRasonMessage(Request $request)
    {
		/*$request->validate([
			'files.*' => 'file|max:2048', // Max 2MB per file
		]);*/
		$validator = Validator::make($request->all(), [
			'files.*' => 'file|max:2048|mimes:jpg,jpeg,png,gif,pdf,doc,docx,xls,xlsx,ppt,pptx,txt,zip,rar', 
		]);
		
		if ($request->hasFile('files')) {
			foreach ($request->file('files') as $file) {
				$mimeType = $file->getMimeType(); // Get MIME type

				if (str_starts_with($mimeType, 'audio/') || str_starts_with($mimeType, 'video/')) {
					return response()->json([
						'status' => 'error',
						'message' => 'Audio and video files are not allowed.'
					], 422);
				}
			}
		}
		
		if ($validator->fails()) {
			return response()->json([
				'status' => 'error',
				'message' => 'Only images, PDFs, Word, Excel, PowerPoint, TXT, ZIP, and RAR files are allowed. File size should not exceed 2MB.'
			], 422);
		}
		
		$uploadedFiles = [];
		$files = '';
		if ($request->hasFile('files')) {
			foreach ($request->file('files') as $file) {
				// Define the destination path inside the public folder
				$destinationPath = public_path('uploads/chat-files');
				
				// Ensure the directory exists
				if (!file_exists($destinationPath)) {
					mkdir($destinationPath, 0777, true);
				}

				// Generate a unique file name
				$fileName = time() . '_' . $file->getClientOriginalName();
				
				// Move file to public/uploads/chat-files
				$file->move($destinationPath, $fileName);
				
				// Save the file path for further use
				if (!in_array('uploads/chat-files/' . $fileName, $uploadedFiles)) {
					$uploadedFiles[] = 'uploads/chat-files/' . $fileName;
				}
			}
		}
		
		//$chat_group_id = substr(sha1(mt_rand()),17,6);
		$edit_id = $request->edit_id;
		if($edit_id!='')
		{
			$message = Manage_chat::find($edit_id);
			$message->message = $request->message;
			$message->save();
			//broadcast(new MessageUpdated($message))->toOthers();
			event(new MessageUpdated($message));
		}
		else
		{
			/*$exists = Manage_chat::where(function ($query) {
				$query->where('sender_id', auth()->id())
					  ->orWhere('receiver_id', auth()->id());
			})->exists();*/
			$exists = Manage_chat::where('unique_chat_id', $request->unique_chat_id)->exists();
				
			if($exists)
			{
				$receiver_id = $request->receiver_id;
			}
			else
			{
				$receiver_id = assignChatReceiverId($request->department_id);
			}
				
			$chatData = Manage_chat::where('unique_chat_id', $request->unique_chat_id)->first();
			
			$userType = User::where('id',$receiver_id)->first()->user_type;
			
			
			if($chatData && !empty($chatData->chat_group_id))
			{
				/*if($request->reason_id !='')
				{
					//echo '1';die;
					$chat_group_id = generate_chat_unique_id(Manage_chat::class,'chat_group_id', $receiver_id);
				}
				else
				{
					//echo '2';die;
					$chat_group_id =  $chatData->chat_group_id; // this is
				}*/
				$chat_group_id =  $chatData->chat_group_id;
			}
			else	
			{
				//echo '3';die;
				//$chat_group_id = substr(sha1(mt_rand()),17,6);
				$chat_group_id = generate_chat_unique_id(Manage_chat::class,'chat_group_id', $receiver_id);
			}
			
			//$userType = User::where('id',$receiver_id)->first()->user_type;
			
			$message = Manage_chat::create([
				'source' => 0,
				'user_type' => $userType,
				'reason' => $request->reason_id ?? null,
				'unique_chat_id' => $request->unique_chat_id,
				'chat_group_id' => $chat_group_id,
				'sender_id' => auth()->id(),
				'receiver_id' => $receiver_id,
				'message' => $request->message,
				'is_read' => 0,
				'created_at' => date('Y-m-d h:i:s'),
			]);
			
			
			foreach($uploadedFiles as $file)
			{
				$file_type = 0;
				$extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
				if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'])) {
					//echo "Image file: " . $file->getClientOriginalName();
					$file_type = 1;
				}
				
				$files = Manage_chat_file::create([
					'manage_chat_id' => $message->id,
					'chat_group_id' => $message->chat_group_id,
					'file_type' => $file_type,
					'file_name' => $file,
					'created_at' => date('Y-m-d h:i:s'),
				]);
			}
			//broadcast(new MessageSent($message))->toOthers();
			broadcast(new MessageSent($message,$uploadedFiles))->toOthers();
			
			/*return response()->json([
				'status' => 'success',
				'message' => 'Message sent successfully.'
			]);*/
		}
    }
	public function message_delete(Request $request)
	{
		$id = $request->id;
		$message = Manage_chat::find($request->id);
    
		if ($message) {
			$message->delete();
			
			$file_data = Manage_chat_file::where('manage_chat_id',$request->id)->get();
			foreach($file_data as $files)
			{
				// unlink the image from folder
				$file_path = public_path($files->file_name);
				//echo $file_path;die;
				if (file_exists($file_path)) {
					unlink($file_path);
				}
			}
			
			Manage_chat_file::where('manage_chat_id',$request->id)->delete();

			broadcast(new MessageDeleted($request->id))->toOthers();

			return response()->json(['success' => true, 'message' => 'Message deleted success-fully.']);
		}

		return response()->json(['success' => false, 'message' => 'Message not found.'], 404);
	}

	public function channel_list()
	{
		$data[] = '';
		return view('channel.index', $data);
	}	
	
	/*public function getChatUsers(Request $request)
	{
		$receiverId = $request->query('receiverId'); // Get receiver ID from request
		\Log::info("Fetching chat users for receiverId: " . ($receiverId ?? 'null'));

		// Fetch chat users where the authenticated user is sender or receiver
		$chatUsers = Manage_chat::where('receiver_id', auth()->id())
			->orWhere('sender_id', auth()->id())
			->with(['sender', 'receiver'])
			->orderBy('created_at', 'desc')
			->get()
			->groupBy(function ($message) {
				return $message->sender_id == auth()->id() ? $message->receiver_id : $message->sender_id;
			});

		// Ensure receiverId is set
		if (!$receiverId && $chatUsers->isNotEmpty()) {
			$receiverId = $chatUsers->keys()->first();
		}

		\Log::info("Resolved receiverId: " . ($receiverId ?? 'null'));

		return view('partials.chat_user_list', [
			'sortedChatUsers' => $chatUsers,
			'receiverId' => $receiverId
		]);
	}*/
	
	public function getChatUsers(Request $request)
	{
		$receiverId = $request->query('receiverId'); // Get receiver ID from request

		// Fetch chat users where the authenticated user is sender or receiver
		$chatUsers = Manage_chat::where('receiver_id', auth()->id())
			->orWhere('sender_id', auth()->id())
			->with(['sender', 'receiver'])
			->orderBy('created_at', 'desc') // Sort by latest message
			->get()
			->groupBy('chat_group_id');
			/*->groupBy(function ($message) {
				return $message->sender_id == auth()->id() ? $message->receiver_id : $message->sender_id;
			});*/

		// If no receiverId is provided, default to the first user in the list
		if (!$receiverId && $chatUsers->isNotEmpty()) {
			$receiverId = $chatUsers->keys()->first();
		}

		// Fetch messages for the selected receiver
		$messages = collect();
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
		}

		// Sort chat users: Unread messages first, then latest messages first
		$sortedChatUsers = $chatUsers->sortByDesc(function ($messages) {
			$latestMessage = $messages->sortByDesc('created_at')->first();
			$hasUnreadMessages = $messages->where('receiver_id', auth()->id())->where('user_type', 1)->where('is_read', 0)->count() > 0;
			return [$hasUnreadMessages, $latestMessage->created_at];
		});

		// Return view with correctly named variable
		return view('partials.chat_user_list', [
			'sortedChatUsers' => $sortedChatUsers, // Make sure Blade file expects this
			'receiverId' => $receiverId
		]);
	}
	
	public function update_chat_read_status(Request $request)
	{
		$receiverId = $request->query('receiverId');
		Manage_chat::where('sender_id',$receiverId)->where('receiver_id',auth()->user()->id)->update(['is_read'=>1]);
		return 1;
	}
	
	public function open_new_chat_bkp($reason_id='')
	{
		//echo $slug; die;
		//$reason_id='';
		$messages = '';
		$chatUsers = [];
		$receiverId = '';
		$chat_group_id = '';
		$receiverName = '';
		$receiverEmail = '';
		$receiverPhone = '';
		$receiverDepartment = '';
		
		$chatUsers = Manage_chat::where('receiver_id', auth()->id())
			->orWhere('sender_id', auth()->id())
			->with(['sender', 'receiver'])
			->orderBy('created_at', 'desc')
			->get()
			->groupBy(function ($message) {
				return $message->sender_id == auth()->id() ? $message->receiver_id : $message->sender_id;
			});
		
			dd($chatUsers);	
		if (!$receiverId && $chatUsers->isNotEmpty()) {
			//\Log::info('Receiver ID was not found, setting to first user.');
			// $receiverId = $chatUsers->keys()->first();
		}
		
		$messages = collect();
		
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
				
			$chat_group_id = $messages[0]->chat_group_id ?? null;
			
			$userData = User::where('id',$receiverId)->first();
			$receiverName = $userData->name;
			$receiverEmail = $userData->email;
			$receiverPhone = $userData->phone_number;
			$receiverDepartment = $userData->department;
		}
		
		return view('chat.dashboard_new_chat', compact('reason_id','messages', 'chatUsers', 'receiverId','chat_group_id','receiverName','receiverEmail','receiverPhone','receiverDepartment'));
	}
	public function open_new_chat($reason_id='', $unique_chat_id='')
	{
		//echo $slug; die;
		//$reason_id='';
		
		$chat_reason = Chat_reason::where('id', $reason_id)->first();
		
		$messages = '';
		$chatUsers = [];
		$receiverId = '';
		$chat_group_id = '';
		$receiverName = '';
		$receiverEmail = '';
		$receiverPhone = '';
		// $receiverDepartment = '';
		$receiverDepartment = $chat_reason->department;
		$chatReason = '';
		
		$chatUsers = Manage_chat::where('receiver_id', auth()->id())
			->orWhere('sender_id', auth()->id())
			->with(['sender', 'receiver'])
			->orderBy('created_at', 'desc')
			->get()
			->groupBy('chat_group_id');
			/*->groupBy(function ($message) {
				return $message->sender_id == auth()->id() ? $message->receiver_id : $message->sender_id;
			});*/
		$check_chat_exists = Manage_chat::where('unique_chat_id', $unique_chat_id)->first();
		// dd($chatUsers);
		
		if (!$receiverId && $check_chat_exists) {
			//\Log::info('Receiver ID was not found, setting to first user.');
			$receiverId = $check_chat_exists->receiver_id;
						
			$messages = collect();			
			if (!empty($receiverId)) {
				/*$messages = Manage_chat::where(function ($query) use ($receiverId) {
						$query->where('sender_id', auth()->id())
							->where('receiver_id', $receiverId);
					})
					->orWhere(function ($query) use ($receiverId) {
						$query->where('sender_id', $receiverId)
							->where('receiver_id', auth()->id());
					})
					->orderBy('id', 'asc')
					->get();*/
				$messages = Manage_chat::where('chat_group_id', $check_chat_exists->chat_group_id)->orderBy('id', 'asc')->get();
					// dd($messages);
				// $chat_group_id = $messages[0]->chat_group_id ?? null;
				$chat_group_id = $check_chat_exists->chat_group_id ?? null;
				
				$userData = User::where('id',$receiverId)->first();
				$receiverName = $userData->name;
				$receiverEmail = $userData->email;
				$receiverPhone = $userData->phone_number;
				$receiverDepartment = $userData->department;
			}
		}
		
		//$chat_reason = Chat_reason::where('id', $reason_id)->first();
		$chatReason = $chat_reason->reason;
		$departments = Department::all();
		
		//Chat status
		$chk_chat_status = Chat_feedback_status::where('chat_group_id', $chat_group_id)->first();
		
		return view('chat.dashboard_new_chat', compact('reason_id','unique_chat_id','chatReason','messages', 'chatUsers', 'receiverId','chat_group_id','receiverName','receiverEmail','receiverPhone','receiverDepartment','departments','chk_chat_status'));
	}
	public function get_department_employee(Request $request){
		$employee = User::where('user_type', 1)->where('department', $request->id)->get();
		/*$html = '<div class="d-flex1">';
		foreach($employee as $val){
			$html .= '<div class="mt-1">
				<label class="custom_check">
					<input type="checkbox" class="css_advantage_feature" name="assign_user[]" value="'.$val->id.'">
					<span class="checkmark" style="margin-top: -1px;"></span>
				</label>
				<label class="col-form-label ms-4">'.$val->name.'</label>
			</div>';
		}
		$html .= '</div>';*/
		$html = '<option value="">Please Select</option>';
		foreach($employee as $val){
			$html .= '<option value="'.$val->id.'">'.$val->name.'</option>';
		}
		
		echo json_encode($html);
	}
	public function submit_assign_employee(Request $request){
		//dd($request->all());
		$first_chat = Manage_chat::where('chat_group_id', $request->chat_group_id)->first();
		$all_chat = Manage_chat::where('chat_group_id', $request->chat_group_id)->get();
		foreach($all_chat as $all_chat_val){
			if($all_chat_val->user_type == 1){
				$receiver = explode(',', $all_chat_val->receiver_id);
				if(!in_array($request->assign_user, $receiver)) {
					$new_receiver = $all_chat_val->receiver_id.','.$request->assign_user;
					$up = Manage_chat::where('id', $all_chat_val->id)->update(['receiver_id' => $new_receiver]);
					
					$chat_gray = explode(',', $all_chat_val->chat_view_gray);
					if(!in_array($request->assign_user, $chat_gray)) {
						array_push($chat_gray, $request->assign_user);
						$new_chat_gray = trim(implode(',', $chat_gray), ',');
						$up = Manage_chat::where('id', $all_chat_val->id)->update(['chat_view_gray' => $new_chat_gray]);
					}
				}
			}else if($all_chat_val->user_type == 2){
				$sender = explode(',', $all_chat_val->sender_id);
				if(!in_array($request->assign_user, $sender)) {
					$new_sender = $all_chat_val->sender_id.','.$request->assign_user;
					$up = Manage_chat::where('id', $all_chat_val->id)->update(['sender_id' => $new_sender]);
					
					$chat_gray = explode(',', $all_chat_val->chat_view_gray);
					if(!in_array($request->assign_user, $chat_gray)) {
						array_push($chat_gray, $request->assign_user);
						$new_chat_gray = trim(implode(',', $chat_gray), ',');
						$up = Manage_chat::where('id', $all_chat_val->id)->update(['chat_view_gray' => $new_chat_gray]);
					}
				}
			}
		}
		echo 1;
	}
	public function entry_chat_status(Request $request){
		$chk_feedback = Chat_feedback_status::where('chat_group_id', $request->chat_group_id)->exists();
		if(!$chk_feedback){
			$feedback = new Chat_feedback_status();
			$feedback->chat_group_id = $request->chat_group_id;
			$feedback->save();
		}
		echo 1;
	}
	public function change_chat_status(Request $request){
		$chk_feedback = Chat_feedback_status::where('chat_group_id', $request->chat_group_id)->exists();
		if($chk_feedback){
			$feedback = Chat_feedback_status::where('chat_group_id', $request->chat_group_id)->first();
			$feedback->chat_status = $request->status;
			$feedback->save();
		}else{
			$feedback = new Chat_feedback_status();
			$feedback->chat_group_id = $request->chat_group_id;
			$feedback->chat_status = $request->status;
			$feedback->save();
		}
		echo 1;
	}
	public function save_feedback_text(Request $request){
		$chk_feedback = Chat_feedback_status::where('chat_group_id', $request->chat_group_id)->exists();
		if($chk_feedback){
			$feedback = Chat_feedback_status::where('chat_group_id', $request->chat_group_id)->first();
			$feedback->chat_status = 1;
			$feedback->feedback_text = $request->feedback_text;
			$feedback->save();
		}else{
			$feedback = new Chat_feedback_status();
			$feedback->chat_group_id = $request->chat_group_id;
			$feedback->chat_status = 1;
			$feedback->feedback_text = $request->feedback_text;
			$feedback->save();
		}
		echo 1;
	}
}
