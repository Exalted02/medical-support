@extends('layouts.app')
@section('styles')
<style>
	.reply-container {
		border: 1px solid #ccc;
		border-radius: 8px;
		padding: 10px;
		width: 600px;
		display: flex;
		flex-direction: column;
	}
	.reply-header {
		display: flex;
		justify-content: space-between;
		cursor: pointer;
		font-size: 14px;
		color: gray;
	}
	.reply-body {
		display: none;
		margin-top: 10px;
	}
	.attachment-preview {
		margin-top: 5px;
		font-size: 12px;
	}
</style>
<script src="https://cdn.tiny.cloud/1/hegwfipkcvvrdp634l0g1o2btu1ntwo76la2024u5o02fwxm/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
@endsection

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
											@foreach($threads as $k=>$thread)
											<li class="nav-item me-0" role="presentation" onclick="openEmail('{{ $thread['messages'][0]['id'] }}')">
												<a class="nav-link text-break mw-100" data-bs-toggle="tab" role="tab" aria-current="page" href="#" aria-selected="false" tabindex="-1">
													{{--<div class="email-subject">{{ $k }}</div>--}}
													<div class="email-subject">{{ $thread['subject'] }}</div>
													<div class="email-date">{{ $thread['messages'][0]['date'] }}</div>
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
									<a href="javascript:void(0)" title="Mike Litorus"><span id="email-thread-subject"></span> {{--<i class="typing-text">Typing...</i>--}}</a>
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
					<div class="chat-contents">
						<div class="chat-content-wrap">
							<div class="chat-wrap-inner">
								<div class="chat-box">
									<div class="chats" id="email-thread-container">
									<div id="email-thread"></div>
									</div>
								</div>
							</div>
						</div>
					</div>
					{{--<div class="chat-footer">
						<div class="message-bar">
							<div class="message-inner">
								<a class="link attach-icon" href="#" data-bs-toggle="modal" data-bs-target="#drag_files"><img src="{{ url('static-image/attachment.png') }}" alt="Attachment Icon"></a>
								<div class="message-area">
									<div class="input-group">
										<textarea class="form-control" placeholder="Type message..."></textarea>
										<button class="btn btn-custom" type="button"><i class="fa-solid fa-paper-plane"></i></button>
									</div>
								</div>
							</div>
						</div>
					</div>--}}
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Reply Modal -->
<div id="replyModal" class="modal fade" tabindex="-1" aria-labelledby="replyModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="replyModalLabel">Reply</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="replyForm" enctype="multipart/form-data">
					@csrf
                    <input type="hidden" id="threadId" name="threadId">
                    <input type="hidden" id="toEmail" name="to">
                    <input type="hidden" id="emailSubject" name="subject">
                    <textarea id="emailBody" class="form-control" rows="4" name="body" placeholder="Type your reply..."></textarea>
					<!-- Attachments -->
					<input type="file" id="attachment" class="mt-2" name="attachments[]" multiple onchange="showAttachments(event)">
					<div id="attachmentPreview" class="attachment-preview"></div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="sendReply()">Send</button>
            </div>
        </div>
    </div>
</div>

@endsection 
@section('scripts')
<script>
    tinymce.init({
        selector: '#emailBody', // Target the textarea
        height: 300,
        menubar: false,
		plugins: 'advlist autolink lists link image charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table paste help wordcount',
		toolbar: 'bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | link',
		images_upload_url: '/upload-image',
		automatic_uploads: true,
        setup: function(editor) {
            editor.on('change', function() {
                tinymce.triggerSave(); // Ensures textarea value is updated
            });
        }
    });
</script>

<script>
    function openEmail(emailId) {
		const emails = @json($threads);
		let threadFound = false;

		for (const threadId in emails) {
			const thread = emails[threadId];

			if (thread.messages.some(msg => msg.id === emailId)) {
				threadFound = true;
				
				// Set the thread subject
				document.getElementById('email-thread-subject').innerText = thread.subject;

				// Clear previous messages
				const threadContainer = document.getElementById('email-thread');
				threadContainer.innerHTML = '';

				thread.messages.forEach(message => {
					const messageHtml = `
						<div class="email-thread">
							<div class="email-header">
								<strong>${message.from}</strong> 
								<span class="email-date">${message.date}</span>
							</div>
							<div class="email-body">${message.body}</div>
							<button class="btn btn-primary btn-sm reply-btn" data-thread="${threadId}" data-to="${message.from}" data-subject="${thread.subject}">Reply</button>
						</div>
					`;
					threadContainer.innerHTML += messageHtml;
				});

				document.getElementById('email-thread-container').style.display = 'block';
				break;
			}
		}

		if (!threadFound) {
			document.getElementById('email-thread-container').style.display = 'none';
		}
	}
	
	/*document.querySelectorAll('.reply-btn').forEach(button => {
        button.addEventListener('click', function () {
            document.getElementById('threadId').value = this.dataset.thread;
            document.getElementById('toEmail').value = this.dataset.to;
            document.getElementById('emailSubject').value = this.dataset.subject;
            new bootstrap.Modal(document.getElementById('replyModal')).show();
        });
    });*/
	document.addEventListener('click', function (event) {
		if (event.target.classList.contains('reply-btn')) {
			console.log("Reply button clicked via delegation!"); // Debugging line
			
			// Get data attributes from the clicked button
			let threadId = event.target.dataset.thread;
			let toEmail = event.target.dataset.to;
			let emailSubject = event.target.dataset.subject;

			// Populate the modal fields
			document.getElementById('threadId').value = threadId;
			document.getElementById('toEmail').value = toEmail;
			document.getElementById('emailSubject').value = emailSubject;

			// Show the modal
			let modal = new bootstrap.Modal(document.getElementById('replyModal'));
			modal.show();
		}
	});



    function sendReply() {
        /*let formData = {
            threadId: document.getElementById('threadId').value,
            to: document.getElementById('toEmail').value,
            subject: document.getElementById('emailSubject').value,
            body: document.getElementById('emailBody').value
        };*/
		let formData = new FormData(document.getElementById("replyForm"));
		
        fetch("{{ url('/send-reply') }}", {
            method: "POST",
			body: formData,
			headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            location.reload();
        })
        .catch(error => console.error('Error:', error));
    }
	
	function showAttachments(event) {
		let fileList = event.target.files;
		let preview = document.getElementById("attachmentPreview");
		preview.innerHTML = "";

		for (let i = 0; i < fileList.length; i++) {
			preview.innerHTML += `<p>${fileList[i].name}</p>`;
		}
	}
</script>
@endsection
