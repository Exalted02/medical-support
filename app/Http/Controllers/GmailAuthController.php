<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Google_Client;
use Google_Service_Gmail;
use Google\Service\Gmail\Message;
use Illuminate\Support\Facades\Mail;

class GmailAuthController extends Controller
{
    private function getClient()
    {
        $client = new Google_Client();
        $client->setClientId(config('google.client_id'));
        $client->setClientSecret(config('google.client_secret'));
        $client->setRedirectUri(config('google.redirect_uri'));
        $client->setAccessType('offline');
        $client->setPrompt('consent');
        $client->setScopes(config('google.scopes'));

        return $client;
    }

    public function redirectToGoogle()
    {
        $client = $this->getClient();
        return redirect($client->createAuthUrl());
    }

    public function handleGoogleCallback(Request $request)
    {
        $client = $this->getClient();

        if ($request->has('code')) {
            $token = $client->fetchAccessTokenWithAuthCode($request->code);
            session(['gmail_token' => $token]);

            return redirect()->route('shared-inboxes');
        }

        return redirect()->route('gmail.auth')->with('error', 'Authentication failed.');
    }

    public function getMessages()
    {
        $client = $this->getClient();
        $token = session('gmail_token');

        if (!$token) {
            return redirect()->route('gmail.auth')->with('error', 'Please authenticate with Gmail.');
        }

        $client->setAccessToken($token);

        if ($client->isAccessTokenExpired()) {
            return redirect()->route('gmail.auth')->with('error', 'Session expired. Please authenticate again.');
        }

        $service = new Google_Service_Gmail($client);
        $messages = $service->users_messages->listUsersMessages('me', [
																	'maxResults' => 20,
																	// 'q' => 'in:inbox'
																]);

        $threads = [];

        foreach ($messages->getMessages() as $message) {
            $msg = $service->users_messages->get('me', $message->getId(), ['format' => 'full']);

            $headers = $msg->getPayload()->getHeaders();
            $subject = '';
            $from = '';
            $threadId = $msg->getThreadId();
            $snippet = $msg->getSnippet();
            $date = $msg->getInternalDate() / 1000; // Convert timestamp
            $body = '';

            foreach ($headers as $header) {
                if ($header->getName() == 'Subject') {
                    $subject = $header->getValue();
                }
                if ($header->getName() == 'From') {
                    $from = $header->getValue();
                }
            }

            // Extract full HTML body
            $payload = $msg->getPayload();
			$body = $snippet;
            if ($payload->getParts()) {
                foreach ($payload->getParts() as $part) {
                    if ($part->getMimeType() == "text/html") {
                        $body = base64_decode(str_replace(['-', '_'], ['+', '/'], $part->getBody()->getData()));
                        break;
                    }
                }
            }else{
				if ($payload->getMimeType() == "text/html") {
					$body = base64_decode(str_replace(['-', '_'], ['+', '/'], $payload->getBody()->getData()));
				}
			}

            if (!isset($threads[$threadId])) {
                $threads[$threadId] = [
                    'subject' => $subject ?: 'No Subject',
                    'messages' => [],
                ];
            }

            $threads[$threadId]['messages'][] = [
                'id' => $msg->getId(),
                'from' => $from,
                'snippet' => $snippet,
                'date' => date('d M Y, H:i A', $date),
                'timestamp' => $date,
                'body' => $body, // Full HTML content
            ];
        }

        // Sort messages within each thread by timestamp (oldest first)
        foreach ($threads as &$thread) {
            usort($thread['messages'], fn($a, $b) => $a['timestamp'] <=> $b['timestamp']);
        }
		// dd($threads);
        // return view('email-index', compact('threads'));
        return view('chat.gmail-chat', compact('threads'));
    }
	public function sendReply(Request $request)
    {
        $client = $this->getClient();
		$token = session('gmail_token');

        if (!$token) {
            return redirect()->route('gmail.auth')->with('error', 'Please authenticate with Gmail.');
        }

        $client->setAccessToken($token);

        if ($client->isAccessTokenExpired()) {
            return redirect()->route('gmail.auth')->with('error', 'Session expired. Please authenticate again.');
        }

        $service = new Google_Service_Gmail($client);
		
        $threadId = $request->input('threadId');
        $to = $request->input('to');
        $subject = "Re: " . $request->input('subject');
        $body = $request->input('body');

        $boundary = uniqid();
		$message = "From: me\r\n";
		$message .= "To: $to\r\n";
		$message .= "Subject: $subject\r\n";
		$message .= "In-Reply-To: <$threadId>\r\n";
		$message .= "References: <$threadId>\r\n";
		$message .= "MIME-Version: 1.0\r\n";
		$message .= "Content-Type: multipart/mixed; boundary=\"$boundary\"\r\n";
		$message .= "\r\n";
		$message .= "--$boundary\r\n";
		$message .= "Content-Type: text/html; charset=UTF-8\r\n";
		$message .= "\r\n";
		$message .= "$body\r\n";

		if ($request->hasFile('attachments')) {
			foreach ($request->file('attachments') as $file) {
				$fileData = base64_encode(file_get_contents($file->getPathname()));
				$message .= "--$boundary\r\n";
				$message .= "Content-Type: " . $file->getClientMimeType() . "; name=\"" . $file->getClientOriginalName() . "\"\r\n";
				$message .= "Content-Disposition: attachment; filename=\"" . $file->getClientOriginalName() . "\"\r\n";
				$message .= "Content-Transfer-Encoding: base64\r\n";
				$message .= "\r\n";
				$message .= chunk_split($fileData) . "\r\n";
			}
		}

		$message .= "--$boundary--";

		$encodedMessage = rtrim(strtr(base64_encode($message), '+/', '-_'), '=');

		$msg = new Message();
		$msg->setRaw($encodedMessage);
		$msg->setThreadId($threadId);

		$service->users_messages->send('me', $msg);
		
		
		
		
		/*$service = new Google_Service_Gmail($client);
		
        $threadId = $request->input('threadId');
        $to = $request->input('to');
        $subject = "Re: " . $request->input('subject');
        $body = $request->input('body');

        $message = "From: me\r\n";
        $message .= "To: $to\r\n";
        $message .= "Subject: $subject\r\n";
        $message .= "In-Reply-To: <$threadId>\r\n";
        $message .= "References: <$threadId>\r\n";
        $message .= "MIME-Version: 1.0\r\n";
        $message .= "Content-Type: text/plain; charset=UTF-8\r\n";
        $message .= "\r\n";
        $message .= "$body";

        $encodedMessage = rtrim(strtr(base64_encode($message), '+/', '-_'), '=');

        $msg = new Message();
        $msg->setRaw($encodedMessage);
        $msg->setThreadId($threadId); // Reply to the same thread

        $service->users_messages->send('me', $msg);*/

        return response()->json(['message' => 'Reply sent successfully!']);
    }

}
