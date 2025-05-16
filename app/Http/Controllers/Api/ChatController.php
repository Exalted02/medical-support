<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use App\Models\Manage_chat;
use App\Models\Manage_chat_file;
use App\Models\Chat_reason;
use App\Models\User;
use App\Events\MessageSent;
use App\Events\MessageUpdated;
use App\Events\MessageDeleted;

use Illuminate\Support\Facades\Validator; 
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
		
		$chat_values = Manage_chat::where(function ($query) use($login_user_id) {
				$query->where('sender_id', $login_user_id)
					  ->orWhere('receiver_id', $login_user_id);
			})->get()->groupBy('chat_group_id');
		
		foreach($chat_values as $k=>$chats_data){
			$chats = $chats_data[0];
			$sender = User::where('id', $chats->receiver_id)->first();
			$issue = Chat_reason::where('id', $chats->reason)->first();
			
			$data[] = [
				'ticket_number' => $k,
				'resident' => '',
				'timestamp' => Carbon::parse($chats->created_at ?? '')->format('M j Y g:iA'),
				'issue' => $issue->reason ?? '',
				'assigned_to' => $sender->name ?? '',
				'reason_id' => $chats->reason ?? 0,
				'receiver_id' => $chats->receiver_id ?? '',
				'chat_group_id' => $chats->chat_group_id ?? '',
				'unique_chat_id' => $chats->unique_chat_id ?? '',
			];
		}
		return response()->json([
            'success' => true,
            'data' => $data
        ]);
	}
	public function send_reason_message(Request $request)
    {
		//\Log::info('Request data: '.json_encode($request->all()));
		/*$request->validate([
			'files.*' => 'file|max:2048', // Max 2MB per file
		]);*/
		/*$validator = Validator::make($request->all(), [
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
		}*/
		
		$uploadedFiles = [];
		/*$files = '';
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
		}*/
		
		//$chat_group_id = substr(sha1(mt_rand()),17,6);
		//\Log::info('Test send message');
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
				$chat_group_id =  $chatData->chat_group_id; // this is
			}
			else	
			{
				//echo '3';die;
				//$chat_group_id = substr(sha1(mt_rand()),17,6);
				$chat_group_id = generate_chat_unique_id(Manage_chat::class,'chat_group_id', $receiver_id);
			}
			
			//$userType = User::where('id',$receiver_id)->first()->user_type;
			$login_user_id = Auth::guard('sanctum')->user()->id;
			$message = Manage_chat::create([
				'source' => 0,
				'user_type' => $userType,
				'reason' => $request->reason_id ?? null,
				'unique_chat_id' => $request->unique_chat_id,
				'chat_group_id' => $chat_group_id,
				'sender_id' => $login_user_id,
				'receiver_id' => $receiver_id,
				'message' => $request->message,
				'is_read' => 0,
				'employee_assign_date' => date('Y-m-d h:i:s'),
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
	public function chat_message_data(Request $request)
    {
		//\Log::info('Request chat_message_data: '.json_encode($request->all()));
		$messages = Manage_chat::where('chat_group_id', $request->chat_group_id)->orderBy('created_at', 'asc')->get();
		return response()->json([
            'success' => true,
            'messages' => $messages,
        ], 200);
    }
	public function update_message(Request $request)
    {
		//\Log::info('Request update_message: '.json_encode($request->all()));
		$messages = Manage_chat::find($request->message_id);
		$messages->message = $request->message;
		$messages->save();
		event(new MessageUpdated($messages));
		return response()->json([
            'success' => true,
            'messages' => $messages,
        ], 200);
    }
	public function delete_message(Request $request)
    {
		//\Log::info('Request delete_message: '.json_encode($request->all()));
		$messages = Manage_chat::find($request->message_id);
		$messages->delete();
		broadcast(new MessageDeleted($request->message_id))->toOthers();
		return response()->json([
            'success' => true,
            'messages' => $messages,
        ], 200);
    }
	public function add_new_reason(Request $request)
    {
		$login_user_id = Auth::guard('sanctum')->user()->id;
		$chk_reason = Chat_reason::whereIn('user_id', [$login_user_id, 1])->where('reason', $request->reason)->first();
		if($chk_reason){
			return response()->json([
				'success' => false,
				'messages' => 'This reason already exists.',
			], 200);
		}
		
		$reason = new Chat_reason();
		$reason->user_id = $login_user_id;
		$reason->reason = $request->reason;
		if($reason->save()){
			return response()->json([
				'success' => true,
				'messages' => 'Reason added successfully.',
			], 200);
		}else{
			return response()->json([
				'success' => false,
				'messages' => 'Reason not added.',
			], 200);
		}
		
    }
}
