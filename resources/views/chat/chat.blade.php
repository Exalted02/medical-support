@extends('layouts.app')
@section('content')
<!-- Page Wrapper -->
@php 
//echo "<pre>";print_r($messages->toArray());die;
$messages2 = $messages;
@endphp
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
										
										@foreach ($chatUsers as $userId => $messages)
											@php
												$chatUser = $messages->first()->sender_id == auth()->id()
													? $messages->first()->receiver
													: $messages->first()->sender;
												$isActive = ($receiverId == $chatUser->id); // Active only if receiverId matches
											@endphp
											<li class="nav-item me-0" role="presentation">
												<a class="nav-link text-break mw-100 user-link {{ $isActive ? 'active' : '' }} message-chat-info"
												   href="{{ route('chat', ['receiverId' => $chatUser->id]) }}"
												   data-userid="{{ $chatUser->id }}">
													<i class="feather-user me-2 align-middle d-inline-block"></i>
													{{ $chatUser->name }}
												</a>
											</li>
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
				<div class="chat-window">
					<div class="fixed-header">
						<div class="navbar">
							<div class="user-details me-auto">
								<div class="float-start user-img">
									<a class="avatar" href="profile.html" title="Mike Litorus">
										<img src="{{ url('static-image/avatar-05.jpg') }}" alt="User Image" class="rounded-circle">
										<span class="status online"></span>
									</a>
								</div>
								<div class="user-info float-start">
									<a href="profile.html" title="Mike Litorus"><span>Mike Litorus</span> {{--<i class="typing-text">Typing...</i>--}}</a>
									{{--<span class="last-seen">Last seen today at 7:50 AM</span>--}}
								</div>
							</div>
							{{--<div class="search-box">
								<div class="input-group input-group-sm">
									<input type="text" placeholder="Search" class="form-control">
									<button type="button" class="btn"><i class="fa-solid fa-magnifying-glass"></i></button>
								</div>
							</div>--}}
							<ul class="nav custom-menu">
								<li class="nav-item">
									<a class="nav-link task-chat profile-rightbar float-end" id="task_chat" href="#task_window"><i class="fa-solid fa-user"></i></a>
								</li>
								<li class="nav-item dropdown has-arrow flag-nav">
									<a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="javascript:void(0);" role="button" data-id="en">
									<p><i class="fa-regular fa-circle-dot text-primary me-2"></i>Open</p>
									</a>
									<div class="dropdown-menu dropdown-menu-right">
										<a href="javascript:void(0);" class="dropdown-item" data-id="en">
											<p><i class="fa-regular fa-circle-dot text-primary me-2"></i>Open</p>
										</a>
										<a href="javascript:void(0);" class="dropdown-item" data-id="fr">
											<p><i class="fa-regular fa-circle-dot text-warning me-2"></i>Waiting</p>
										</a>
										<a href="javascript:void(0);" class="dropdown-item" data-id="it">
											<p><i class="fa-regular fa-circle-dot text-success me-2"></i>Resolved</p>
										</a>
									</div>
								</li>
								<li class="nav-item dropdown has-arrow flag-nav">
									<a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="javascript:void(0);" role="button" data-id="en">
									<p>Assign</p>
									</a>
									<div class="dropdown-menu dropdown-menu-right assign-dropdown">
										<a href="javascript:void(0);" class="dropdown-item" data-id="en">
											<p>
												Unassigned 
												<i class="fa-solid fa-check"></i>
											</p>
										</a>
										<a href="javascript:void(0);" class="dropdown-item" data-id="en">
											<p>
												<img class="assign-dropdown-image" src="{{ url('static-image/avatar-09.jpg') }}" alt="User Image">
												Employee One
												<i class="fa-solid fa-check"></i>
											</p>
										</a>
										<a href="javascript:void(0);" class="dropdown-item" data-id="fr">
											<p>
												<img class="assign-dropdown-image" src="{{ url('static-image/avatar-09.jpg') }}" alt="User Image">
												Employee Two
												<i class="fa-solid fa-check"></i>
											</p>
										</a>
										<a href="javascript:void(0);" class="dropdown-item" data-id="it">
											<p>
												<img class="assign-dropdown-image" src="{{ url('static-image/avatar-09.jpg') }}" alt="User Image">
												Employee Three
												<i class="fa-solid fa-check"></i>
											</p>
										</a>
									</div>
								</li>
								{{--<li class="nav-item">
									<a href="voice-call.html" class="nav-link"><i class="fa-solid fa-phone"></i></a>
								</li>
								<li class="nav-item">
									<a href="video-call.html" class="nav-link"><i class="fa-solid fa-video"></i></a>
								</li>--}}
								<li class="nav-item dropdown dropdown-action">
									<a aria-expanded="false" data-bs-toggle="dropdown" class="nav-link dropdown-toggle" href="#"><i class="material-icons">more_vert</i></a>
									<div class="dropdown-menu dropdown-menu-right">
										<a href="javascript:void(0)" class="dropdown-item">Mark as read</a>
										<a href="javascript:void(0)" class="dropdown-item">Mark as unread</a>
										<a href="javascript:void(0)" class="dropdown-item">Delete Conversations</a>
										<a href="javascript:void(0)" class="dropdown-item">Settings</a>
									</div>
								</li>
							</ul>
						</div>
					</div>
					@php 
						//echo "<pre>";print_r($messages->toArray());die;
					@endphp
					<div class="chat-contents">
						<div class="chat-content-wrap">
							<div class="chat-wrap-inner">
								<div class="chat-box">
									<div class="chats" id="chat-messages">
										
										@foreach ($messages2 as $message)
										@if($message->sender_id == auth()->id())
											<div class="chat chat-right">
												@if ($message->sender_id != auth()->id())
													<div class="chat-avatar">
														<a href="#" class="avatar">
															<img src="{{ url('static-image/avatar-05.jpg') }}" alt="User Image">
														</a>
													</div>
												@endif
												<div class="chat-body">
													<div class="chat-bubble">
														<div class="chat-content" data-id="{{ $message->id}}">
															<p>{{ $message->message }}</p>
															<span class="chat-time">{{ \Carbon\Carbon::parse($message->created_at)->diffForHumans() }}</span>
														</div>
														<div class="chat-action-btns">
															<ul>
																<li><a href="javascript:void(0);" class="edit-msg update-msg" data-id="{{ $message->id }}" data-sender="{{ $message->sender_id }}" data-receiver="{{ $message->receiver_id  }}" data-msg="{{   $message->message }}"><i class="fa-solid fa-pencil"></i></a></li>
																<li><a href="javascript:void(0);" class="del-msg" data-id="{{ $message->id}}" data-url="{{ route('message.delete')}}"><i class="fa-regular fa-trash-can"></i></a></li>
															</ul>
														</div>
													</div>
												</div>
											</div>
											@else
												<div class="chat chat-left">
												@if ($message->sender_id != auth()->id())
													<div class="chat-avatar">
														<a href="#" class="avatar">
															<img src="{{ url('static-image/avatar-05.jpg') }}" alt="User Image">
														</a>
													</div>
												@endif
												<div class="chat-body">
													<div class="chat-bubble">
														<div class="chat-content">
															<p>{{ $message->message }}</p>
															<span class="chat-time">{{ \Carbon\Carbon::parse($message->created_at)->diffForHumans() }}</span>
														</div>
														{{--<div class="chat-action-btns">
															<ul>
																<li><a href="#" class="edit-msg"><i class="fa-solid fa-pencil"></i></a></li>
																<li><a href="#" class="del-msg"><i class="fa-regular fa-trash-can"></i></a></li>
															</ul>
														</div>--}}
													</div>
												</div>
											</div>
											@endif
										@endforeach
									</div>
									
								</div>
							</div>
						</div>
					</div>
					<div class="chat-footer">
					<div id="file-preview" class=""></div>
						<div class="message-bar">
							<div class="message-inner">
								<a class="link attach-icon" id="triggerFileUpload" href="#"  data-bs-target="#drag_files"><img src="{{ url('static-image/attachment.png') }}" alt="Attachment Icon"></a>
								
								
								<form id="chat-file-upload-form" enctype="multipart/form-data">
									<div class="message-area">
										<div class="input-group">
										<input type="file" id="chat-files" name="files[]" multiple class="d-none">
											<textarea class="form-control" id="msg" placeholder="Type message..."></textarea>
											<button type="button" class="clear-msg-btn cross-button" style="position: absolute; right: 50px; background: none; border: none; cursor: pointer;display:none;">
												<i class="fa-solid fa-xmark"></i>
											</button>
											{{--<button class="btn btn-custom send-button" data-url="{{ route('send.message') }}"  type="button"><i class="fa-solid fa-paper-plane"></i></button>--}}
											<button class="btn btn-custom" type="button"><i class="fa-solid fa-paper-plane"></i></button>
											<input type="hidden" id="edit_id" value="">
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<input type="hidden" id="receiverId">
@endsection 
@section('scripts')
<script src="{{ url('front-assets/js/page/chat.js') }}"></script>
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<!--<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>-->
<script src="https://cdn.jsdelivr.net/npm/dayjs@1/dayjs.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dayjs/1.11.9/plugin/utc.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/dayjs@1/plugin/relativeTime.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
	let userLinks = document.querySelectorAll('.user-link');

	userLinks.forEach(link => {
		link.addEventListener('click', function (event) {
			// Remove active class from all links
			userLinks.forEach(l => l.classList.remove('active'));

			// Add active class to the clicked user
			this.classList.add('active');
			
			event.preventDefault(); // Prevent default link behavior
            let userId = this.getAttribute('data-userid');
			//alert(userId);
            window.location.href = `/chat?receiverId=${userId}`; // Manually update URL
			
		});
	});
});

$(document).ready(function() {
    var receiverId = {!! json_encode($receiverId) !!};
	//var authUserId = {!! json_encode(auth()->id()) !!};
	$('#receiverId').val(receiverId);
	//alert(receiverId);
	//$(document).on('click','.send-button', function () {
	$('.btn-custom').on('click', function () {
	//$('#chat-file-upload-form').on('submit', function (e) {
		
		let formData = new FormData($('#chat-file-upload-form')[0]); // Get form data
		
		let message = $('#msg').val();
		let edit_id = $('#edit_id').val();
		//let URL = $(this).data('url');
		let URL = "{{ route('send.message') }}";
		var receiverId = $('#receiverId').val();
		
		let files = $('#chat-files')[0].files;
		$.each(files, function (index, file) {
            formData.append("files[]", file);
        });
		
		formData.append('message', message);
        formData.append('receiver_id', receiverId);
        formData.append('edit_id', edit_id);
        formData.append('_token', "{{ csrf_token() }}");
		
		//alert(receiverId);
		//if (message.trim() !== '') 
		//{
			$.ajax({
				url: URL,
				type: "POST",
				data: formData,
				processData: false,
				contentType: false,
				success: function(response) {
					console.log("Message sent:", response);
					
					/*let chatHTML = '<div class="chat-content" data-id=" '+ response.id + '">' + response.message ? '<p>' +response.message +'</p> : ''}';

					// If files exist, append them
					if (response.files && response.files.length > 0) {
						response.files.forEach(file => {
							// Check if the file is an image or another file type
							if (/\.(jpg|jpeg|png|gif)$/i.test(file)) {
								chatHTML += '<img src="' + file + '" class="chat-image-preview">';
							} else {
								chatHTML += '<a href="' + file + '" target="_blank" class="chat-file-link">📎 Download File</a>';
							}
						});
					}

					chatHTML += '</div>';*/
					
					// Clear input & file preview after sending
					$('#msg').val('');
					$('#file-preview').html('');
					$('#edit_id').val('');

					// Append new message if not an edit
					if (edit_id) {
						// Update existing message in chat box
						$('.chat-content[data-id="'+ edit_id +'"] p').text(message);
						$('#edit_id').val(''); // Reset edit ID after update
					} else {
						// Append new message as usual
						//chatBox.append(chatHTML);
					}

					// Scroll to latest message
					$('.chat-box').scrollTop($('.chat-box')[0].scrollHeight);
				},
				error: function(xhr) {
					console.error("Error sending message:", xhr.responseText);
				}
			});
		//}
		
        /*if (message.trim() !== '') {
            $.post(URL, {
                data:formData
            }, function () {
                if (edit_id) {
                // Update existing message in chat box
                $('.chat-content[data-id="'+ edit_id +'"] p').text(message);
                $('#edit_id').val(''); // Reset edit ID after update
				} else {
					// Append new message as usual
					//chatBox.append(chatHTML);
				}
				$('#msg').val(''); // Clear input field
				chatBox.scrollTop(chatBox.prop("scrollHeight"));
            });
        }*/
    });
	
	let selectedFiles = [];

    // Click on attach icon triggers file input
    $('#triggerFileUpload').on('click', function (e) {
        e.preventDefault();
        $('#chat-files').click();
    });

    // Handle file selection
	$('#chat-files').on('change', function (e) {
		selectedFiles = e.target.files;
		$('#file-preview').html(""); // Clear previous previews

		$.each(selectedFiles, function (index, file) {
			let fileType = file.type.split('/')[0]; // Get file type (image, video, etc.)

			if (fileType === 'image') {
				let reader = new FileReader();
				reader.onload = function (event) {
					$('#file-preview').append(
						'<div class="file-item">' +
							'<img src="' + event.target.result + '" class="file-preview-img">' +
						'</div>'
					);
				};
				reader.readAsDataURL(file);
			}
		});

		uploadFiles(selectedFiles);
	});
    
});
function uploadFiles(files) {
	let formData = new FormData();
	formData.append("_token", "{{ csrf_token() }}");
	$.each(files, function (index, file) {
		formData.append("files[]", file);
	});
}
</script>
<script>
	dayjs.extend(dayjs_plugin_utc);
	dayjs.extend(dayjs_plugin_relativeTime);
	//var pusherKey = "{{ env('PUSHER_APP_KEY') }}";
    //var pusherCluster = "{{ env('PUSHER_APP_CLUSTER') }}";
	var authUserId = {!! json_encode(auth()->id()) !!};
	
	var chatBox = $('#chat-messages');
    var pusher = new Pusher("{{ env('PUSHER_APP_KEY') }}", {
        cluster: "{{ env('PUSHER_APP_CLUSTER') }}",
        encrypted: true
    });

    var channel = pusher.subscribe('chat-channel');

    channel.bind('message-sent', function(data) {
        console.log("New message received: ", data);
		/*if (!data.files || !Array.isArray(data.files)) {
			console.log("No files received.");
			data.files = []; // Ensure it is an empty array to avoid errors
		}*/
		
		
        //console.log("File length: ", data.files.length);
        if (!data || !data.message) {
            console.log("No message data received.");
            return;
        }
		
		if (!data || !data.message) return;
		
		if (data.receiver_id != authUserId && data.sender_id != authUserId) {
			console.log("Message not for this user. Ignoring.");
			return;
		}
		//alert(data.sender_id);
		var messageTime = dayjs.utc(data.created_at).local().fromNow(true) + " ago";
		
		var app_url =  "{{ env('APP_URL') }}";
		var avatar = app_url + '/static-image/avatar-05.jpg';
		//alert(avatar);
		
		var chatClass = (data.sender_id == authUserId) ? 'chat-right' : 'chat-left';
		
		var editdeleteDiv = '';
		if(chatClass=='chat-right')
		{
			editdeleteDiv ='<div class="chat-action-btns"><ul><li><a href="javascropt:void(0);" class="edit-msg update-msg" data-id="'+ data.id +'" data-sender="'+ data.sender_id+'" data-receiver="'+ data.receiver_id +'" data-msg="'+ data.message +'"><i class="fa-solid fa-pencil"></i></a></li><li><a href="javascript:void(0);" class="del-msg"  data-id="'+ data.id +'" data-url="{{ route('message.delete')}}"><i class="fa-regular fa-trash-can"></i></a></li></ul></div>';
		}
		
		var avatar = (data.sender_id != authUserId) ? 
			'<div class="chat-avatar"><a href="#" class="avatar">'+ avatar +'<img src="${userImageUrl}" alt="User Image"></a></div>' 
			: '';
			
		var fileHTML = '';

		// If files exist, append images or file links
		if (data.files && data.files.length > 0) {
			data.files.forEach(file => {
				fileHTML += '<img src="' + file + '" class="chat-image-preview">';
				/*if (/\.(jpg|jpeg|png|gif)$/i.test(file)) {
					 alert(file);
					fileHTML += '<img src="' + file + '" class="chat-image-preview">';
				} else {
					fileHTML += '<a href="'+ file +'" target="_blank" class="chat-file-link">📎 Download File</a>';
				}*/
			});
		}
		
			
		//alert(data.message.message);
		var chatHTML = '<div class="chat '+ chatClass +'"><div class="chat-body"><div class="chat-bubble"><div class="chat-content" data-id="' + data.id + '"><p>' + (data.message ? '<p>' + data.message + '</p>' : '') + '</p> '+  fileHTML + '<span class="chat-time">' + messageTime + '</span></div>' + editdeleteDiv + '</div></div></div>';

		chatBox.append(chatHTML);
		chatBox.scrollTop(chatBox.prop("scrollHeight"));
	});
	
	channel.bind('message-updated', function(data) {
		//console.log("Updated Message:", data);
		let updatedMessage = data.message; // Ensure message is correctly accessed
		//let messageElement = $('.chat-content[data-id="' + data.id + '"] p');
		let messageElement = $('.chat-content[data-id="' + data.id + '"]');
		if (messageElement.length) {
			console.log(data.message);
			messageElement.text(updatedMessage);
		}
	});
	channel.bind('message-deleted', function (data) {
		//console.log("Deleting message ID:", data.id);
		$('.chat-content[data-id="' + data.id + '"]').closest('.chat').remove();
	});

</script>
@endsection
