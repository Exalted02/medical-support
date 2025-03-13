<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Http;

class FacebookAuthController extends Controller
{ 
	// Step 1: Redirect to Facebook for Login
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')
            ->scopes([
                'pages_show_list', 
                'pages_read_engagement', 
                'pages_manage_metadata', 
                'pages_messaging'
            ])
            ->redirect();
    }

    // Step 2: Handle Facebook Callback and Get Access Token
    public function handleFacebookCallback()
    {
        try {
            $user = Socialite::driver('facebook')->user();
            session(['fb_access_token' => $user->token]);
			
            return redirect()->route('facebook-pages'); // Redirect to page list
        } catch (\Exception $e) {
			return redirect()->route('channel')->with('error', 'Authentication failed.');
            // return redirect('/channel')->with('error', 'Facebook login failed');
        }
    }

    // Step 3: Get User's Facebook Pages
    public function getPages()
    {
        $accessToken = session('fb_access_token');
        if (!$accessToken) {
            return redirect()->route('facebook.auth');
        }

        $url = "https://graph.facebook.com/v18.0/me/accounts?access_token={$accessToken}";
        $response = Http::get($url);
        $data['data'] = $response->json();
		// dd($data);
		return view('facebook.facebook-pages', $data);
        // return response()->json($data);
    }

    // Step 4: Fetch Conversations from a Selected Page
    public function getMessages($pageId, Request $request)
    {
        $pageAccessToken = $request->query('access_token');
        if (!$pageAccessToken) {
            return redirect()->route('facebook.auth');
        }

        $url = "https://graph.facebook.com/v18.0/{$pageId}/conversations?fields=id,updated_time,participants&access_token={$pageAccessToken}";
        // $url = "https://graph.facebook.com/v18.0/me/conversations?access_token={$pageAccessToken}";
        $response = Http::get($url);
		// dd($response);
		// dd($response->json());
		// dd($pageId);
		$data['data'] = $response->json();
		$data['token'] = $request->query('access_token');
		$data['pageId'] = $pageId;
		return view('facebook.facebook-chat', $data);
        // return response()->json($response->json());
    }

    // Step 5: Fetch Messages from a Specific Conversation
    public function getConversationMessages(Request $request)
    {
        $pageAccessToken = $request->input('accessToken');
		$conversationId = $request->input('cId');
		$receiverId = $request->input('uId');
    
		if (!$pageAccessToken) {
			return redirect()->route('facebook.auth');
		}

		// Facebook Graph API endpoint to get conversation messages
		$url = "https://graph.facebook.com/v18.0/{$conversationId}/messages?fields=message,from,created_time&access_token={$pageAccessToken}";

		try {
			$response = Http::get($url);
			$messages = $response->json();
			// Sort messages within each thread by timestamp (oldest first)
			foreach ($messages as &$thread) {
				usort($thread, fn($a, $b) => $a['created_time'] <=> $b['created_time']);
			}
			// dd($messages);
			echo view('facebook.conversation', ['messages' => $messages['data'] ?? [], 'conversationId' => $conversationId, 'receiverId' => $receiverId, 'pageAccessToken' => $pageAccessToken])->render();
		} catch (\Exception $e) {
			return response()->json(['error' => $e->getMessage()], 500);
		}
    }
	public function sendMessage(Request $request)
	{
		$request->validate([
			'conversation_id' => 'required|string',
			'receiver_id' => 'required|string',
			'message' => 'required|string',
			'access_token' => 'required|string',
		]);

		$conversationId = $request->input('conversation_id');
		$receiverId = $request->input('receiver_id');
		$messageText = $request->input('message');
		$pageAccessToken = $request->input('access_token');

		$url = "https://graph.facebook.com/v18.0/me/messages?access_token={$pageAccessToken}";

		$response = Http::post($url, [
			'recipient' => ['id' => $receiverId],
			'message' => ['text' => $messageText]
		]);

		$responseData = $response->json();

		if (isset($responseData['error'])) {
			return response()->json(['error' => $responseData['error']['message']], 400);
		}

		return response()->json(['success' => 'Message sent successfully']);
	}
}
