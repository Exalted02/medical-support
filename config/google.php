<?php
return [
    'client_id' => env('GOOGLE_CLIENT_ID'),
    'client_secret' => env('GOOGLE_CLIENT_SECRET'),
    'redirect_uri' => env('GOOGLE_REDIRECT_URI'),
    'scopes' => [
        'https://www.googleapis.com/auth/gmail.readonly', // Read emails
        'https://www.googleapis.com/auth/gmail.modify',   // Modify emails
        'https://www.googleapis.com/auth/gmail.send'      // Send emails
    ]
];
