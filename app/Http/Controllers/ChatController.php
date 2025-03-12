<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Ticket;
use App\Models\Employee_manage_tickets;
use App\Models\Manage_chat;
use App\Models\Manage_chat_file;
use App\Events\MessageSent;
use App\Events\MessageUpdated;
use App\Events\MessageDeleted;

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

		if (!$receiverId && $chatUsers->isNotEmpty()) {
			//\Log::info('Receiver ID was not found, setting to first user.');
			$receiverId = $chatUsers->keys()->first();
		}

		$chat_group_id = '';
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
				
			$chat_group_id = $messages[0]->chat_group_id;
		}
		
		return view('chat.chat', compact('messages', 'chatUsers', 'receiverId','chat_group_id'));
	}

	public function sendMessage(Request $request)
    {
		$request->validate([
			'files.*' => 'file|max:2048', // Max 2MB per file
		]);
		
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
			$chatData = Manage_chat::where(function ($query) use ($request) {
				$query->where('sender_id', auth()->id())
					  ->where('receiver_id', $request->receiver_id);
			})
			->orWhere(function ($query) use ($request) {
				$query->where('sender_id', $request->receiver_id)
					  ->where('receiver_id', auth()->id());
			})
			->first();
			
			if(!empty($chatData->chat_group_id) || $chatData->chat_group_id!='')
			{
				$chat_group_id =  $chatData->chat_group_id;
			}
			else	
			{
				$chat_group_id = substr(sha1(mt_rand()),17,6);
			}				

			$message = Manage_chat::create([
				'source' => 0,
				'user_type' => auth()->user()->user_type,
				'chat_group_id' => $chat_group_id,
				'sender_id' => auth()->id(),
				'receiver_id' => $request->receiver_id,
				'message' => $request->message,
				'is_read' => 1,
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
		}
        //return response()->json($message);
		
		/*return response()->json([
			'id' => $message->id,
			'message' => $message->message,
			//'files' => $uploadedFiles // Send the list of uploaded files
		]);*/
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
}
