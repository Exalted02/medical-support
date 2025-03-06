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
}
