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
		// dd($from.'//'.$to);
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
    public function call_log(Request $request)
    {
        $rcsdk = new SDK(
            env('RINGCENTRAL_CLIENT_ID'),
            env('RINGCENTRAL_CLIENT_SECRET'),
            env('RINGCENTRAL_SERVER_URL')
        );

        $platform = $rcsdk->platform();

        try {
            $platform->login(['jwt' => env('RINGCENTRAL_JWT')]);
			$queryParams = array(
				// 'phoneNumber' => '+13104042226',
				// 'dateFrom' => "2024-01-01T00:00:00.000Z",
				// 'dateTo' => "2025-05-31T23:59:59.009Z",
				'view' => "Detailed"
			);
			$endpoint = "/restapi/v1.0/account/~/extension/~/call-log";
			$resp = $platform->get($endpoint, $queryParams);
			$call_log = $resp->json()->records;
			// dd($call_log[0]);
			return view('employee-call-log', compact('call_log'));
        } catch (\RingCentral\SDK\Http\ApiException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
                'details' => json_decode((string) $e->apiResponse()->response()->getBody(), true)
            ], 500);
        }
    }
}
