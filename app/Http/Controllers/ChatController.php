<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Ticket;
use App\Models\Employee_manage_tickets;

class ChatController extends Controller
{
    public function index()
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
}
