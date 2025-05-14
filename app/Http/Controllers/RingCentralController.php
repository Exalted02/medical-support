<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Manage_chat;
use App\Models\User;
use RingCentral\SDK\SDK;
use DB;

class RingCentralController extends Controller
{
    public function ring_employee(Request $request)
    {
		$first_chat = Manage_chat::where('chat_group_id', $request->chat_group_id)->first();
		
		$sender_details = User::where('id', $first_chat->sender_id)->first();
		$from = $sender_details->phone_number;
		
		$receiver_details = User::where('id', $first_chat->receiver_id)->first();
		$to = $receiver_details->phone_number;
		
        $rcsdk = new SDK(
            env('RINGCENTRAL_CLIENT_ID'),
            env('RINGCENTRAL_CLIENT_SECRET'),
            env('RINGCENTRAL_SERVER_URL'),
            'LaravelApp'
        );

        $platform = $rcsdk->platform();

        try {
            $platform->login(['jwt' => env('RINGCENTRAL_JWT')]);

            $response = $platform->post('/account/~/extension/~/ring-out', [
                'from' => ['phoneNumber' => $from],
                'to' => ['phoneNumber' => $to],
                'playPrompt' => true
            ]);
			DB::table('store_data')->insert(
				['json_data' => json_encode($response->json()), 'created_date' => date('Y-m-d H:i:s')]
			);
            return response()->json([
                'status' => 'Call initiated',
                'data' => $response->json()
            ]);
        } catch (\RingCentral\SDK\Http\ApiException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
                'details' => json_decode((string) $e->apiResponse()->response()->getBody(), true)
            ], 500);
        }
    }
}
