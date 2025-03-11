<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Inbox</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; font-family: Arial, sans-serif; }
        .email-container { margin-top: 30px; }
        .email-thread { background: white; padding: 15px; border-radius: 8px; border: 1px solid #ddd; margin-bottom: 20px; }
        .email-header { font-size: 14px; font-weight: bold; margin-bottom: 5px; }
        .email-date { font-size: 12px; color: gray; margin-left: 10px; }
        .email-body { font-size: 14px; padding: 10px; background: #f1f1f1; border-radius: 5px; margin-top: 5px; }
        .email-replies { margin-left: 30px; border-left: 3px solid #007bff; padding-left: 15px; margin-top: 10px; }
    </style>
</head>
<body>

<div class="container email-container">
    <h2 class="text-center">Inbox</h2>

    @forelse($threads as $thread)
        <div class="email-thread">
            <!-- Main Message -->
            <div class="email-main">
                <div class="email-header">
                    <strong>{{ $thread['messages'][0]['from'] }}</strong> 
                    <span class="email-date">{{ $thread['messages'][0]['date'] }}</span>
                </div>
                <div class="email-body">
                    {!! $thread['messages'][0]['body'] !!}
                </div>
            </div>

            <!-- Replies -->
            <div class="email-replies">
                @foreach(array_slice($thread['messages'], 1) as $message)
                    <div class="email-reply">
                        <div class="email-header">
                            <strong>{{ $message['from'] }}</strong> 
                            <span class="email-date">{{ $message['date'] }}</span>
                        </div>
                        <div class="email-body">
                            {!! $message['body'] !!}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @empty
        <p class="text-center">No emails found.</p>
    @endforelse
</div>

</body>
</html>
