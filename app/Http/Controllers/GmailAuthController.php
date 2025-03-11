<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Google_Client;
use Google_Service_Gmail;

class GmailAuthController extends Controller
{
    private function getClient()
    {
        $client = new Google_Client();
        $client->setClientId(config('services.google.client_id'));
        $client->setClientSecret(config('services.google.client_secret'));
        $client->setRedirectUri(config('services.google.redirect_uri'));
        $client->setAccessType('offline');
        $client->setPrompt('consent');
        $client->setScopes(config('services.google.scopes'));

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

            return redirect()->route('gmail.inbox');
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
        $messages = $service->users_messages->listUsersMessages('me', ['maxResults' => 20, 'q' => 'in:inbox',]);

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
            if ($payload->getParts()) {
                foreach ($payload->getParts() as $part) {
                    if ($part->getMimeType() == "text/html") {
                        $body = base64_decode(str_replace(['-', '_'], ['+', '/'], $part->getBody()->getData()));
                        break;
                    }
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

        return view('email-index', compact('threads'));
    }
}
