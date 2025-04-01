<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\Models\Conversation;
// use App\Models\Message;
// use App\Models\Employee;
// use App\Events\NewMessageReceived;

class WhatsAppAuthController extends Controller
{ 
	public function receiveWhatsAppMessages(Request $request) {
		\Log::info('Webhook request:', $request->all());

		$verifyToken = env('WHATSAPP_VERIFY_TOKEN', 'my_secure_token');
		$hubVerifyToken = $request->query('hub_verify_token');
		$hubChallenge = $request->query('hub_challenge');

		if ($hubVerifyToken === $verifyToken) {
			return response($hubChallenge, 200)->header('Content-Type', 'text/plain');
		}

		return response()->json(['error' => 'Invalid token'], 403);
        
        /*$data = $request->all();
		if (isset($data['entry'][0]['changes'][0]['value']['messages'])) {
            foreach ($data['entry'][0]['changes'][0]['value']['messages'] as $message) {
                $customerPhone = $message['from'];
                $text = $message['text']['body'] ?? '';

                // Find an open conversation or create a new one
                $conversation = Conversation::where('customer_phone', $customerPhone)->where('status', 'open')->first();

                if (!$conversation) {
                    $employee = Employee::where('status', 'available')->orderBy('last_assigned_at', 'asc')->first();

                    if (!$employee) {
                        return response()->json(['error' => 'No available employees'], 400);
                    }

                    $conversation = Conversation::create([
                        'customer_phone' => $customerPhone,
                        'status' => 'open',
                        'employee_id' => $employee->id
                    ]);

                    $employee->update(['status' => 'busy', 'last_assigned_at' => now()]);
                }

                Message::create([
                    'conversation_id' => $conversation->id,
                    'sender' => 'customer',
                    'message' => $text
                ]);

                event(new NewMessageReceived($conversation->id, 'customer', $text));
            }
        }

        return response()->json(['status' => 'success']);*/
    }
}
