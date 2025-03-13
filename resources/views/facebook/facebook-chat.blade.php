@extends('layouts.app')
@section('content')
<!-- Page Wrapper -->
<div class="page-wrapper">
	<div class="chat-main-row">
		<div class="chat-main-wrapper">
			<div class="col-lg-3 message-view chat-profile-view chat-sidebar" id="task_window">
				<div class="content-full">
					<div class="display-table">
						<div class="table-row">
							<div class="table-body">
								<div class="table-content">
									<div class="chat-user-list">
										<ul class="nav nav-tabs flex-column vertical-tabs-3" role="tablist">
											<input type="hidden" id="ajaxurl" value="{{route('facebook-conversation')}}">
											@foreach($data['data'] as $conversation)
												@php
													$conversationId = $conversation['id'];
													$participants = $conversation['participants']['data'] ?? [];
												@endphp

												@foreach ($participants as $participant)
													@php
														$userId = $participant['id'];
														$userName = $participant['name'];
													@endphp

													@if ($userId !== $pageId)
														<li class="nav-item me-0" role="presentation" onclick="openChat('{{ $conversationId }}', '{{ $userId }}')">
															<a class="nav-link text-break mw-100" data-bs-toggle="tab" role="tab" aria-current="page" href="#" aria-selected="false" tabindex="-1">
																{{--<div class="email-subject">Conversation ID: {{ $conversationId }}</div>
																<div class="email-participant">User: {{ $userName }} (ID: {{ $userId }})</div>--}}
																<i class="feather-user me-2 align-middle d-inline-block"></i>{{ $userName }}
															</a>
														</li>
													@endif
												@endforeach
											@endforeach
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- /Chat Right Sidebar -->
			<!-- Chats View -->
			<div class="col-lg-9 message-view task-view">
				<div class="chat-window" id="chat-window">
					
				</div>
			</div>
		</div>
	</div>
</div>

@endsection 
@section('scripts')
<script>
    function openChat(cId, uId) {
		var URL = $('#ajaxurl').val();
		const accessToken = @json($token);
		var csrfToken = $('meta[name="csrf-token"]').attr('content'); // Get CSRF token
		$.ajax({
			url: URL,
			type: "POST",
			data: {cId:cId, uId:uId, accessToken: accessToken, _token: csrfToken},
			dataType: 'html',
			success: function(response) {
				$('#chat-window').html(response);
			},
		});
		// fetch(`/facebook/messages/${pageId}?access_token=${accessToken}`)
	}
</script>
<script>
	// document.getElementById("replyForm").addEventListener("submit", function(event) {
	$(document).on("submit", "#replyForm", function(event) {
		event.preventDefault();

		let conversationId = document.getElementById("conversation_id").value;
		let receiverId = document.getElementById("receiver_id").value;
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
				receiver_id: receiverId,
				message: message,
				access_token: accessToken
			})
		})
		.then(response => response.json())
		.then(data => {
			let responseMessage = document.getElementById("responseMessage");
			if (data.success) {
				//responseMessage.innerText = "Message sent successfully!";
				document.getElementById("message").value = "";
			} else {
				//responseMessage.innerText = "Error: " + data.error;
			}
		})
		.catch(error => console.error("Error sending message:", error));
	});
</script>
@endsection
