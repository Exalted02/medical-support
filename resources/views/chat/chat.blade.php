@extends('layouts.app')
@section('content')
<!-- Page Wrapper -->
@php 
//echo "<pre>";print_r($messages->toArray());die;
//echo "<pre>";print_r($chatUsers->toArray());die;
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
										
										@foreach ($chatUsers as $cg => $messages)
											@php
												//$chatUser = $messages->first()->sender_id == auth()->id() ? $messages->first()->receiver : $messages->first()->sender;
												$firstMessage = $messages->first();
												$senderIds = explode(',', $firstMessage->sender_id);
												$receiverIds = explode(',', $firstMessage->receiver_id);

												if (in_array(auth()->id(), $senderIds)) {
													$chatUser = $firstMessage->receiver;
												} else {
													$chatUser = $firstMessage->sender;
												}
												$isActive = ($receiverId == $chatUser?->id); // Active only if receiverId matches
												
												// Check if any message from this user is unread
												//$hasUnreadMessages = $messages->where('receiver_id', auth()->id())->where('user_type',1)->where('is_read', 0)->count() > 0;
												$hasUnreadMessages = $messages->filter(function ($message) {
													$receiverIds = explode(',', $message->receiver_id);
													return in_array(auth()->id(), $receiverIds)
														&& $message->user_type == 1
														&& $message->is_read == 0;
												})->count() > 0;
											@endphp
											<li class="nav-item me-0" role="presentation">
												<a class="nav-link text-break mw-100 user-link {{ $isActive ? 'active' : '' }} {{ $hasUnreadMessages ? 'unread-message' : '' }} message-chat-info"
												   href="{{ route('chat', ['receiverId' => $chatUser?->id, 'chatGroup' => $cg]) }}"
												   data-userid="{{ $chatUser?->id }}" data-chat="{{ $cg }}">
													<i class="feather-user me-2 align-middle d-inline-block"></i>
													{{--{{ $chatUser?->name }}--}}
													Ticket #{{ $cg }}
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
									<a href="javascript:void(0)" title="Mike Litorus"><span>{{ $receiverName ?? '' }}</span> {{--<i class="typing-text">Typing...</i>--}}</a>
									<span class="last-seen">{{ $receiverEmail ?? '' }} {{ $receiverPhone ? '('.  $receiverPhone .')' : '' }}</span>
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
									<a href="voice-call.html" class="nav-link"><i class="fa-solid fa-magnifying-glass"></i></a>
								</li>
								<li class="nav-item">
									<a href="javascript:void(0)" class="nav-link call-employee"><i class="fa-solid fa-phone"></i></a>
								</li>
								<li class="nav-item">
									<a href="video-call.html" class="nav-link"><i class="fa-solid fa-video"></i></a>
								</li>
								<li class="nav-item">
									<a href="video-call.html" class="nav-link"><i class="fa-solid fa-user-plus"></i></a>
								</li>
								{{--<li class="nav-item">
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
								<li class="nav-item dropdown dropdown-action">
									<a aria-expanded="false" data-bs-toggle="dropdown" class="nav-link dropdown-toggle" href="#"><i class="material-icons">more_vert</i></a>
									<div class="dropdown-menu dropdown-menu-right">
										<a href="javascript:void(0)" class="dropdown-item">Mark as read</a>
										<a href="javascript:void(0)" class="dropdown-item">Mark as unread</a>
										<a href="javascript:void(0)" class="dropdown-item">Delete Conversations</a>
										<a href="javascript:void(0)" class="dropdown-item">Settings</a>
									</div>
								</li>--}}
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
										
										@php 
										  $fileData = App\Models\Manage_chat_file::where('manage_chat_id', $message->id)->get();
											$senderIds = explode(',', $message->sender_id);
										@endphp
										@if(isset($senderIds[0]) && $senderIds[0] == auth()->id())
											<div class="chat chat-right">
												@if ($message->sender_id != auth()->id())
												{{--<div class="chat-avatar">
														<a href="#" class="avatar">
															<img src="{{ url('static-image/avatar-05.jpg') }}" alt="User Image">
														</a>
													</div>--}}
												@endif
												
												@if(!empty($message->message))
												<div class="chat-body">
													<div class="chat-bubble">
														<div class="chat-content chat-text-section" data-id="{{ $message->id}}">
															<p>{{ $message->message }}</p>
															<span class="chat-time">{{ \Carbon\Carbon::parse($message->created_at)->diffForHumans() }}</span>
														</div>
														<div class="chat-action-btns">
															<ul>
																<li><a href="javascript:void(0);" class="edit-msg update-msg" data-id="{{ $message->id }}" data-sender="{{ $message->sender_id }}" data-receiver="{{ $message->receiver_id  }}" data-msg="{{   $message->message }}"><i class="fa-solid fa-pencil"></i></a></li>
																<li><a href="javascript:void(0);" class="del-msg" data-id="{{ $message->id}}" data-url="{{ route('message.delete')}}" data-classname="chat-text-section"><i class="fa-regular fa-trash-can"></i></a></li>
															</ul>
														</div>
													</div>
												</div>
												@else 
												<div class="chat-body">	
													<div class="chat-bubble">
														<div class="chat-content img-content chat-file-section" data-id="{{ $message->id}}">
															<div class="chat-img-group clearfix">
															@foreach($fileData as $files)
															
															@php
																$filePath = url($files->file_name);
																$fileExtension = pathinfo($files->file_name, PATHINFO_EXTENSION);
															@endphp
															
															@if(in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif']))
																<a class="chat-img-attach" data-fancybox="chat-gallery" href="{{ url($files->file_name) }}">
																	<img width="80" height="80" src="{{ url( $files->file_name) }}">
																</a>
															@else 
																@php
																$fileIcon = "fa-file"; 

																if (in_array($fileExtension, ['pdf'])) {
																	$fileIcon = "fa-file-pdf text-danger"; // PDF (red)
																} elseif (in_array($fileExtension, ['doc', 'docx'])) {
																	$fileIcon = "fa-file-word text-primary"; // Word (blue)
																} elseif (in_array($fileExtension, ['xls', 'xlsx'])) {
																	$fileIcon = "fa-file-excel text-success"; // Excel (green)
																} elseif (in_array($fileExtension, ['ppt', 'pptx'])) {
																	$fileIcon = "fa-file-powerpoint text-warning"; // PowerPoint (orange)
																} elseif (in_array($fileExtension, ['zip', 'rar'])) {
																	$fileIcon = "fa-file-archive text-muted"; // Compressed file
																} elseif (in_array($fileExtension, ['txt'])) {
																	$fileIcon = "fa-file-alt text-secondary"; // Text file
																}
															@endphp
															<div class="chat-file">
																<a href="{{ route('file.download', ['filename' => basename($filePath)]) }}" class="chat-file-link">
																	<i class="fa {{ $fileIcon }} fa-2x"></i>
																</a>
															</div>
															
															@endif
															@endforeach
															</div>
															<span class="chat-time">{{ \Carbon\Carbon::parse($message->created_at)->diffForHumans() }}</span>
														</div>
														<div class="chat-action-btns">
															<ul>
																<li><a href="javascript:void(0);" class="del-msg" data-id="{{ $message->id}}" data-url="{{ route('message.delete')}}" data-classname="chat-file-section"><i class="fa-regular fa-trash-can"></i></a></li>
															</ul>
														</div>
													</div>
												</div>
												@endif
											</div>
											@else
												<div class="chat chat-left">
												@if ($message->sender_id != auth()->id())
												{{--<div class="chat-avatar">
														<a href="#" class="avatar">
															<img src="{{ url('static-image/avatar-05.jpg') }}" alt="User Image">
														</a>
													</div>--}}
												@endif
												@if(!empty($message->message))
												@php
													$gray = explode(',', $message->chat_view_gray);
												@endphp
												<div class="chat-body">
													<div class="chat-bubble">
														<div class="chat-content {{ in_array(auth()->id(), $gray) ? 'hasGray' : '' }}">
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
												@else 
													
												<div class="chat-body">	
													<div class="chat-bubble">
														<div class="chat-content img-content">
															<div class="chat-img-group clearfix">
															@foreach($fileData as $files)
															
															@php
																$filePath = url($files->file_name);
																$fileExtension = pathinfo($files->file_name, PATHINFO_EXTENSION);
															@endphp
															
															@if(in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif']))
																<a class="chat-img-attach" data-fancybox="chat-gallery" href="{{ url($files->file_name) }}">
																	<img width="80" height="80" src="{{ url( $files->file_name) }}">
																</a>
																@else 
																@php
																	$fileIcon = "fa-file"; // Default icon

																	if (in_array($fileExtension, ['pdf'])) {
																		$fileIcon = "fa-file-pdf text-danger"; // PDF (red)
																	} elseif (in_array($fileExtension, ['doc', 'docx'])) {
																		$fileIcon = "fa-file-word text-primary"; // Word (blue)
																	} elseif (in_array($fileExtension, ['xls', 'xlsx'])) {
																		$fileIcon = "fa-file-excel text-success"; // Excel (green)
																	} elseif (in_array($fileExtension, ['ppt', 'pptx'])) {
																		$fileIcon = "fa-file-powerpoint text-warning"; // PowerPoint (orange)
																	} elseif (in_array($fileExtension, ['zip', 'rar'])) {
																		$fileIcon = "fa-file-archive text-muted"; // Compressed file
																	} elseif (in_array($fileExtension, ['txt'])) {
																		$fileIcon = "fa-file-alt text-secondary"; // Text file
																	}
																@endphp	
																<div class="chat-file">
																	<a href="{{ route('file.download', ['filename' => basename($filePath)]) }}" class="chat-file-link">
																		<i class="fa {{ $fileIcon }} fa-2x"></i>
																	</a>
																</div>
																@endif
																@endforeach
															</div>
															<span class="chat-time">{{ \Carbon\Carbon::parse($message->created_at)->diffForHumans() }}</span>
														</div>
													</div>
												</div>
												@endif
												
											</div>
											@endif
										@endforeach
									</div>
									@if(isset($chk_chat_status))
										@if($chk_chat_status->chat_status == 0)
											
										@else
											<div class="text-center"><span class="badge badge-soft-danger">Ticket closed</span></div>
										@endif
									@endif
								</div>
							</div>
						</div>
					</div>
					
					@if(!isset($chk_chat_status) || $chk_chat_status->chat_status == 0)
					<div class="chat-footer">
					<div id="file-preview" class=""></div>
					<form id="chat-file-upload-form" enctype="multipart/form-data">
					<span id="error-message"></span>
						<div class="message-bar">
						
							<div class="message-inner">
								<a class="link attach-icon" id="triggerFileUpload" href="#"  data-bs-target="#drag_files"><img src="{{ url('static-image/attachment.png') }}" alt="Attachment Icon"></a>
								
							    
								{{--<form id="chat-file-upload-form" enctype="multipart/form-data">--}}
									<div class="message-area">
										<div class="input-group">
										<input type="file" id="chat-files" name="files[]" multiple class="d-none">
											<textarea class="form-control" id="msg" placeholder="Type message..."></textarea>
											<button type="button" class="clear-msg-btn cross-button" style="position: absolute; right: 50px; background: none; border: none; cursor: pointer;display:none;">
												<i class="fa-solid fa-xmark"></i>
											</button>
											
											<button class="btn btn-custom" type="button"><i class="fa-solid fa-paper-plane"></i></button>
											<input type="hidden" id="edit_id" value="">
										</div>
									</div>
									{{--</form>--}}
							</div>
						  
						</div>
					</form>
					</div>
					@endif
					<input type="hidden" id="reason_id" value=''>
				</div>
			</div>
		</div>
	</div>
</div>
<input type="hidden" id="receiverId">
<input type="hidden" id="receiver_department">
<input type="hidden" id="chat_group_id">
{{--<button class="btn btn-custom send-button" data-url="{{ route('send.message') }}"  type="button"><i class="fa-solid fa-paper-plane"></i></button>--}}

@endsection 
@section('scripts')
<script src="{{ url('front-assets/js/page/chat.js') }}"></script>
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<!--<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>-->
<script src="https://cdn.jsdelivr.net/npm/dayjs@1/dayjs.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dayjs/1.11.9/plugin/utc.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/dayjs@1/plugin/relativeTime.js"></script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.css">
<!-- Fancybox JS -->
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.umd.js"></script>

<script>

document.addEventListener("DOMContentLoaded", function () {
    /*document.querySelector('.chat-user-list').addEventListener('click', function (event) {
        let clickedElement = event.target.closest('.user-link');
        if (!clickedElement) return; // If click is not on a .user-link, do nothing
        
        event.preventDefault(); // Prevent default link behavior

        // Remove active class from all user links
        document.querySelectorAll('.user-link').forEach(link => link.classList.remove('active'));

        // Add active class to clicked link
        clickedElement.classList.add('active');

        let userId = clickedElement.getAttribute('data-userid');
        let cg = clickedElement.getAttribute('data-chat');
        // alert(cg);
		var app_url =  "{{ env('APP_URL') }}";
        fetch(`${app_url}/chat/updateReadStatus?receiverId=${userId}&chatGroup=${cg}`)
            .then(response => response.text())
            .then(html => {
				//alert(html);
                window.location.href = app_url + '/chat?receiverId=' + userId + '&chatGroup=' + cg;
            })
            .catch(error => console.error('Error fetching user list:', error));
    });*/
});


/*document.addEventListener("DOMContentLoaded", function () {
	let userLinks = document.querySelectorAll('.user-link');

	userLinks.forEach(link => {
		link.addEventListener('click', function (event) {
			// Remove active class from all links
			userLinks.forEach(l => l.classList.remove('active'));

			// Add active class to the clicked user
			this.classList.add('active');
			
			event.preventDefault(); // Prevent default link behavior
            let userId = this.getAttribute('data-userid');
			alert(userId);
			
			fetch('/chat/updateReadStatus?receiverId=' + userId)
				.then(response => response.text())
				.then(html => {
					alert(html);
					window.location.href = `/chat?receiverId=${userId}`;
				})
				.catch(error => console.error('Error fetching user list:', error));
			
            //window.location.href = `/chat?receiverId=${userId}`; // Manually update URL
			
		});
	});
});*/

let selectedFiles = [];
$(document).ready(function() {
	
	var receiverId = {!! json_encode($receiverId) !!};
	//var authUserId = {!! json_encode(auth()->id()) !!};
	$('#receiverId').val(receiverId);
	 var receiverDept = {!! json_encode($receiverDepartment) !!};
	 //alert(receiverId);
	$('#receiver_department').val(receiverDept);
	
	$('.btn-custom').on('click', function () {
	
		let formData = new FormData($('#chat-file-upload-form')[0]); // Get form data
		
		let reason_id = $('#reason_id').val();
		let message = $('#msg').val();
		let edit_id = $('#edit_id').val();
		//let URL = $(this).data('url');
		let URL = "{{ route('send.message') }}";
		var receiverId = $('#receiverId').val();
		//alert("receiverId ->" + receiverId);
		var department_id = $('#receiver_department').val();
		var chat_group_id = $('#chat_group_id').val();
		
		let files = $('#chat-files')[0].files;
		$.each(files, function (index, file) {
            formData.append("files[]", file);
        });
		
		formData.append('message', message);
        formData.append('receiver_id', receiverId);
        formData.append('edit_id', edit_id);
        formData.append('department_id', department_id);
        formData.append('chat_group_id', chat_group_id);
        formData.append('_token', "{{ csrf_token() }}");
		
		formData.append('reason_id', reason_id);
		
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
					$('#reason_id').val('');
					//alert(response.message);
					
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
					
					//first_chat();
				},
				error: function(xhr, status, error) {
					console.error("Error sending message:", xhr.responseText);
					let response = xhr.responseJSON;
					if (response && response.message) {
						let errorMessage = response.message;
						$("#error-message").text(errorMessage).css("color", "red").fadeIn();

						// Hide the message after 5 seconds
						setTimeout(function() {
							$("#error-message").fadeOut();
						}, 5000);
						
					} else {
						alert("Something went wrong!"); 
					}
				}
			});
		//}
		
        
    });
	
	// file select code 
	// Click on attach icon triggers file input
    $('#triggerFileUpload').on('click', function (e) {
        e.preventDefault();
        $('#chat-files').click();
    });

    // Handle file selection
	$('#chat-files').on('change', function (e) {
		let files = Array.from(e.target.files); 
		selectedFiles = selectedFiles.concat(files);

		updateFilePreview();
		updateFileInput();
	});

	// Remove file on clicking cross icon
	$(document).on('click', '.remove-file', function () {
		let index = $(this).parent('.file-item').data('index');
		selectedFiles.splice(index, 1);
		$(this).parent('.file-item').remove();

		updateFileIndexes();
		updateFileInput();
	});
});

function updateFileIndexes() {
    $('.file-item').each(function (index) {
        $(this).attr('data-index', index);
    });
}

function uploadFiles(files) {
	let formData = new FormData();
	formData.append("_token", "{{ csrf_token() }}");
	files.forEach((file) => {
        formData.append("files[]", file);
    });
}



function updateFilePreview() {
    $('#file-preview').html(""); // Clear existing preview

    selectedFiles.forEach((file, index) => {
		
		let fileType = file.type.split('/')[0];
		let fileExtension = file.name.split('.').pop().toLowerCase();
		let filePreviewHTML = '';
		
        /*let reader = new FileReader();
        reader.onload = function (event) {
            $('#file-preview').append('<div class="file-item" data-index="'+ index +'"><span class="remove-file">&times;</span><img src="' + event.target.result + '" class="file-preview-img"></div>'
            );
        };
        reader.readAsDataURL(file);*/
		
		if (fileType === 'image') {
			let reader = new FileReader();
			reader.onload = function (event) {
				filePreviewHTML = '<div class="file-item" data-index="' +index +'"><span class="remove-file">&times;</span><img src="' + event.target.result +'" class="file-preview-img"></div>';
				$('#file-preview').append(filePreviewHTML);
			};
			reader.readAsDataURL(file);
        } else {
          
            let fileIcon = getFileIcon(fileExtension);
            filePreviewHTML = '<div class="file-item" data-index="' + index +'"><span class="remove-file">&times;</span><div class="file-placeholder">' + fileIcon + '</div><span class="file-name">' + file.name + '</span></div>';
            $('#file-preview').append(filePreviewHTML);
        }
    });
}
function updateFileInput() {
    let dataTransfer = new DataTransfer();

    selectedFiles.forEach((file) => {
        dataTransfer.items.add(file);
    });

    $('#chat-files')[0].files = dataTransfer.files; // Update input files
}
function getFileIcon(extension) {
    let icons = {
        'pdf': '📕',    // PDF icon
        'doc': '📄',    // Word icon
        'docx': '📄',
        'xls': '📊',    // Excel icon
        'xlsx': '📊',
        'ppt': '📽',    // PowerPoint icon
        'pptx': '📽',
        'txt': '📜',    // Text file icon
        'zip': '📦',    // ZIP file icon
        'rar': '📦',
        'mp4': '🎥',    // Video file icon
        'mp3': '🎵'     // Audio file icon
    };

    return icons[extension] || '📁'; // Default file icon
}

/*function first_chat()
{
	var URL = 
	$.ajax({
		url: URL,
		type: "POST",
		data: formData,
		processData: false,
		contentType: false,
		success: function(response) {
			
		}
	});
}*/
</script>

<script>
	var receiver_id = {!! json_encode($receiverId) !!};
	var chat_group_id = {!! json_encode($chat_group_id) !!};
	//alert(chat_group_id);
	$('#chat_group_id').val(chat_group_id);
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
	
	channel.bind('chat-close', function(data) {
		if(chat_group_id != ''){
			if(chat_group_id == data.chat_group_id){
				location.reload();
			}
		}
	});	
    channel.bind('message-sent', function(data) {
        console.log("New message received: ", data);
		
		if(chat_group_id =='')
		{
			$('#chat_group_id').val(data.chat_group_id);
			$('#receiverId').val(data.receiver_id);
		}
		//--for show latest message that users send
		let userId = data.sender_id;
		//alert(userId);
		let userLink = document.querySelector('.user-link[data-userid="' + userId + '"]');
		var rec_id = $('#receiverId').val();
		//var rec_id = data.sender_id;
		//alert("hi "+ rec_id);
		//if (userLink) {
			// Move user to the top by reloading the chat user list
			//alert('ok');
			var app_url =  "{{ env('APP_URL') }}";
			fetch(`${app_url}/chat/latest-users?receiverId=${rec_id}`)
				.then(response => response.text())
				.then(html => {
					//alert(html);
					//$('.chat-user-list').html = html;
					document.querySelector('.chat-user-list').innerHTML = html;
				})
				.catch(error => console.error('Error fetching user list:', error));

			// Change text color to black if unread
			//userLink.style.color = "black";
			//userLink.style.fontWeight = "bold";
		//}
		
		//-------------
		var chat_group_id = $('#chat_group_id').val();
		//alert(chat_group_id);
		//alert(data.chat_group_id);
		// for instant chat show 
		/*if(chat_group_id =='')
		{
			$('#chat_group_id').val(data.chat_group_id);
			$('#receiverId').val(data.receiver_id);
		}
		else if (data.chat_group_id != chat_group_id)
		{
			return;
		}*/
		
		
		
		
		if (data.chat_group_id != chat_group_id)
		{
			return;
		}
		
		
		
		
		var app_url =  "{{ env('APP_URL') }}";
		var fileHTML = '';
		var filePath = '';
		var chatHTML = '';
		// If files exist, append images or file links
		if(data.files || Array.isArray(data.files))
		{
			console.log("File lengthsss: ", data.files.length);
			console.log("File namesss: ", data.files[0]);
		}
	
		var messageTime = dayjs.utc(data.created_at).local().fromNow(true) + " ago";
		
		var senderIds = [];

		// Normalize and split if needed
		if (typeof data.sender_id === 'string' && data.sender_id.includes(',')) {
			senderIds = data.sender_id.split(',');
		} else {
			senderIds = [String(data.sender_id)];
		}
		// var chatClass = (data.sender_id == authUserId) ? 'chat-right' : 'chat-left';
		var chatClass = (senderIds[0] == authUserId) ? 'chat-right' : 'chat-left';
		
		var editdeleteDiv = '';
		if(chatClass=='chat-right')
		{
			if(data.files.length > 0)
			{
				editdeleteDiv ='<div class="chat-action-btns"><ul><li></li><li><a href="javascript:void(0);" class="del-msg"  data-id="'+ data.id +'" data-url="{{ route('message.delete')}}"><i class="fa-regular fa-trash-can"></i></a></li></ul></div>';
			}
			else{
			  editdeleteDiv ='<div class="chat-action-btns"><ul><li><a href="javascropt:void(0);" class="edit-msg update-msg" data-id="'+ data.id +'" data-sender="'+ data.sender_id+'" data-receiver="'+ data.receiver_id +'" data-msg="'+ data.message +'"><i class="fa-solid fa-pencil"></i></a></li><li><a href="javascript:void(0);" class="del-msg"  data-id="'+ data.id +'" data-url="{{ route('message.delete')}}"><i class="fa-regular fa-trash-can"></i></a></li></ul></div>';
			}
		}
		
		var userImageUrl = app_url + '/' + 'static-image/avatar-05.jpg';
		
		
		var avatar = '';
		if(chatClass=='chat-left')
		{
			//avatar = '<div class="chat-avatar"><a href="#" class="avatar"><img src="' + userImageUrl + '" alt="User Image"></a></div>';
		}
			
		//alert(data.message.message); data.sender_id != authUserId
		if(data.message != null)
		{
			var chatHTML = '<div class="chat '+ chatClass +'">'+ avatar +'<div class="chat-body"><div class="chat-bubble"><div class="chat-content" data-id="' + data.id + '"><p>' + (data.message ? '<p>' + data.message + '</p>' : '') + '</p> <span class="chat-time">' + data.created_at + '</span></div>' + editdeleteDiv + '</div></div></div>';
		}
		
		
		if(data.files.length > 0)
		{
			//let imageGroup = "chat-gallery-" + Date.now();
			let imageGroup = "chat-gallery"; 
			
			chatHTML += '<div class="chat '+ chatClass +'">';
				chatHTML += '<div class="chat-body">';
				chatHTML += '<div class="chat-bubble">';
				chatHTML += '<div class="chat-content img-content" data-id="">';
				chatHTML += '<div class="chat-img-group clearfix">';
			data.files.forEach(file => {
				filePath  = app_url +'/'+ file;	
				if (/\.(jpg|jpeg|png|gif)$/i.test(file)) {
					chatHTML += '<a data-fancybox="' + imageGroup + '" class="chat-img-attach" href="' + filePath + '">';
					chatHTML += '<img width="80" height="80" src="' + filePath + '" alt="Placeholder Image">';
					chatHTML += '</a>';
				}
				else {
					
					let fileIcon = "fa-file"; // Default generic file icon

					// Check for specific file types and assign appropriate icons
					if (/\.(pdf)$/i.test(file)) {
						fileIcon = "fa-file-pdf text-danger"; // PDF icon (red)
					} else if (/\.(doc|docx)$/i.test(file)) {
						fileIcon = "fa-file-word text-primary"; // Word file icon (blue)
					} else if (/\.(xls|xlsx)$/i.test(file)) {
						fileIcon = "fa-file-excel text-success"; // Excel file icon (green)
					} else if (/\.(ppt|pptx)$/i.test(file)) {
						fileIcon = "fa-file-powerpoint text-warning"; // PowerPoint icon (orange)
					} else if (/\.(zip|rar)$/i.test(file)) {
						fileIcon = "fa-file-archive text-muted"; // Compressed file icon
					} else if (/\.(txt)$/i.test(file)) {
						fileIcon = "fa-file-alt text-secondary"; // Text file icon
					}
					
					// If the file is not an image (e.g., PDF, DOC)
					chatHTML += '<div class="chat-file">';
					chatHTML += '<a href="' + filePath + '" target="_blank" class="chat-file-link">';
					chatHTML += '<i class="fa ' + fileIcon + ' fa-2x"></i>';
					chatHTML += '</a>';
					chatHTML += '</div>';
				}
			});	
			
			chatHTML += '</div>';
			chatHTML += '<span class="chat-time">'+ data.created_at +'</span>';
			chatHTML += '</div>';
			chatHTML += editdeleteDiv;
			chatHTML += '</div>';
			chatHTML += '</div>';
			chatHTML += '</div>';
			
			$(".chat-container").append(chatHTML);
			Fancybox.bind("[data-fancybox='chat-gallery']", {});
		}
		
		//alert(chatHTML);
		chatBox.append(chatHTML);
		chatBox.scrollTop(chatBox.prop("scrollHeight"));
	});
	channel.bind('chat-assign', function(data) {
		var rec_id = $('#receiverId').val();
		var app_url =  "{{ env('APP_URL') }}";
			fetch(`${app_url}/chat/latest-users?receiverId=${rec_id}`)
				.then(response => response.text())
				.then(html => {
					//alert(html);
					//$('.chat-user-list').html = html;
					document.querySelector('.chat-user-list').innerHTML = html;
				})
				.catch(error => console.error('Error fetching user list:', error));
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
    
	
	/*document.addEventListener("DOMContentLoaded", function() {
		Fancybox.bind("[data-fancybox='chat-gallery']", {}); // Fixed group name
		//Fancybox.bind("[data-fancybox]", {});
	});	*/
</script>
@endsection
