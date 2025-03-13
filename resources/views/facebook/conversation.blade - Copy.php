<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facebook Conversation</title>
	<meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <h1>Conversation ID: {{ $conversationId }}</h1>
    
    @if(empty($messages))
        <p>No messages found.</p>
    @else
        <ul>
            @foreach($messages as $message)
                <li>
                    <strong>{{ $message['from']['name'] ?? 'Unknown' }}</strong>: {{ $message['message'] ?? '(No message content)' }}
                    <br>
                    <small>Sent at: {{ $message['created_time'] }}</small>
                </li>
            @endforeach
        </ul>
    @endif

    <h2>Send a Reply</h2>
    <form id="replyForm">
        <input type="hidden" id="conversation_id" value="{{ $conversationId }}">
        <input type="hidden" id="access_token" value="{{ request()->query('access_token') }}">
        <textarea id="message" placeholder="Type your message..." required></textarea>
        <button type="submit">Send</button>
    </form>

    <p id="responseMessage"></p>

    <a href="/facebook">Back to Page List</a>

    <script>
		document.getElementById("replyForm").addEventListener("submit", function(event) {
			event.preventDefault();

			let conversationId = document.getElementById("conversation_id").value;
			let accessToken = document.getElementById("access_token").value;
			let message = document.getElementById("message").value;

			fetch("/facebook/send-message", {
				method: "POST",
				headers: {
					"Content-Type": "application/json",
					"X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
				},
				body: JSON.stringify({
					conversation_id: conversationId,
					message: message,
					access_token: accessToken
				})
			})
			.then(response => response.json())
			.then(data => {
				let responseMessage = document.getElementById("responseMessage");
				if (data.success) {
					responseMessage.innerText = "✅ Message sent successfully!";
					document.getElementById("message").value = "";
				} else {
					responseMessage.innerText = "❌ Error: " + data.error;
				}
			})
			.catch(error => console.error("Error sending message:", error));
		});
	</script>

</body>
</html>
