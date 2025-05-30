<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Manage_chat;
use App\Models\User;
use RingCentral\SDK\SDK;
use DB;

class RingCentralController extends Controller
{
    public function ring_employee_bkp(Request $request)
    {
		$first_chat = Manage_chat::where('chat_group_id', $request->chat_group_id)->first();
		
		$sender_details = User::where('id', $first_chat->sender_id)->first();
		$from = $sender_details->phone_number;
		
		$receiver_details = User::where('id', $first_chat->receiver_id)->first();
		$to = $receiver_details->phone_number;
		
		$sdk = new SDK(
			env('RINGCENTRAL_CLIENT_ID'),
			env('RINGCENTRAL_CLIENT_SECRET'),
			env('RINGCENTRAL_SERVER_URL')
		);

		$platform = $sdk->platform();

		$platform->login([
			'username' => env('RINGCENTRAL_USERNAME'),
			'extension' => env('RINGCENTRAL_EXTENSION'),
			'password' => env('RINGCENTRAL_PASSWORD')
		]);

		// Get devices
		$devices = $platform->get('/restapi/v1.0/account/~/extension/~/device');
		$deviceId = $devices->json()['records'][0]['id'] ?? null;

		if (!$deviceId) {
			throw new \Exception("No device found");
		}

		// Initiate CallOut
		$response = $platform->post("/restapi/v1.0/account/~/telephony/sessions/call-out", [
			'from' => [
				'deviceId' => $deviceId
			],
			'to' => [
				'phoneNumber' => '+1234567890' // number to call
			]
		]);

		dd($response->json());
	}
    public function ring_employee(Request $request)
    {
		$first_chat = Manage_chat::where('chat_group_id', $request->chat_group_id)->first();
		// dd($first_chat);
		$sender_details = User::where('id', $first_chat->receiver_id)->first();
		$from = $sender_details->phone_number; //Employee
		
		$receiver_details = User::where('id', $first_chat->sender_id)->first();
		$to = $receiver_details->phone_number; //Client
		// dd($from.'//'.$to);
        $rcsdk = new SDK(
            env('RINGCENTRAL_CLIENT_ID'),
            env('RINGCENTRAL_CLIENT_SECRET'),
            env('RINGCENTRAL_SERVER_URL'),
            'LaravelApp'
        );

        $platform = $rcsdk->platform();

        try {
            $login = $platform->login(['jwt' => env('RINGCENTRAL_JWT')]);
            $response = $platform->post('/account/~/extension/~/ring-out', [
                'from' => ['phoneNumber' => $to],
                'to' => ['phoneNumber' => $from],
                'playPrompt' => true
            ]);
			/*$response = $platform->post('/account/~/telephony/call-out', [
				'from' => [ 'phoneNumber' => $from ], // Your RingCentral number
				// 'from' => [ 'deviceId' => '59474004' ], // Your RingCentral number
				'to'   => [ 'phoneNumber' => $to ], // The callee
				// 'callerId' => [ 'phoneNumber' => $from ], // Caller ID to show
				// 'playPrompt' => true
			]);*/
			DB::table('store_data')->insert(
				['json_data' => json_encode($response->json()), 'created_date' => date('Y-m-d H:i:s')]
			);
            return response()->json([
                'status' => 'success',
                'data' => $response->json()
            ]);
        } catch (\RingCentral\SDK\Http\ApiException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
                'details' => json_decode((string) $e->apiResponse()->response()->getBody(), true)
            ]);
        }
    }
    public function disconnect_call(Request $request)
    {
		$rcsdk = new SDK(
            env('RINGCENTRAL_CLIENT_ID'),
            env('RINGCENTRAL_CLIENT_SECRET'),
            env('RINGCENTRAL_SERVER_URL'),
            'LaravelApp'
        );

        $platform = $rcsdk->platform();

        try {
            $platform->login(['jwt' => env('RINGCENTRAL_JWT')]);

            // $response = $platform->delete('/restapi/v1.0/account/accountId/telephony/sessions/'.$request->telephone_session_id);
            $response = $platform->delete('/restapi/v1.0/account/~/extension/~/ring-out/'.$request->telephone_session_id);
			// dd($response);
			$statusCode = $response->response()->getStatusCode();
            return response()->json([
                'status' => 'Call drop',
                'data' => $statusCode
            ]);
        } catch (\RingCentral\SDK\Http\ApiException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
                'details' => json_decode((string) $e->apiResponse()->response()->getBody(), true)
            ], 500);
        }
	}
    public function call_log(Request $request, $page = '')
    {
        $rcsdk = new SDK(
            env('RINGCENTRAL_CLIENT_ID'),
            env('RINGCENTRAL_CLIENT_SECRET'),
            env('RINGCENTRAL_SERVER_URL')
        );

        $platform = $rcsdk->platform();

        try {
            $platform->login(['jwt' => env('RINGCENTRAL_JWT')]);
			// Get the current extension info
			// $response = $platform->get('/restapi/v1.0/account/~/extension/~');
			// $extensionData = $response->json();
			// dd($extensionData);
			
			
			
			$queryParams = array(
				// 'phoneNumber' => '+13104042226',
				// 'dateFrom' => "2024-01-01T00:00:00.000Z",
				// 'dateTo' => "2025-05-31T23:59:59.009Z",
				'view' => "Detailed"
			);
			$page = isset($request->page) && $request->page != null ? $request->page : 1;
			$endpoint = "/restapi/v1.0/account/~/extension/~/call-log?page=".$page;
			// $endpoint = "/restapi/v1.0/account/~/extension/200/call-log?page=".$page;
			$resp = $platform->get($endpoint, $queryParams);
			$call_log = $resp->json()->records;
			$navigation = [
				'nextPage' => $resp->json()->navigation->nextPage ?? null,
				'prevPage' => $resp->json()->navigation->previousPage ?? null,
			];
			// dd($resp->json());
			return view('employee-call-log', compact('call_log', 'navigation', 'page'));
        } catch (\RingCentral\SDK\Http\ApiException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
                'details' => json_decode((string) $e->apiResponse()->response()->getBody(), true)
            ], 500);
        }
    }
}
