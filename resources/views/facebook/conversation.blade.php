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
				<div class="chats" id="chat-list">
					@if(empty($messages))
						<p>No messages found.</p>
					@else
						@foreach($messages as $message)
							<div class="chat chat-{{ $message['from']['id'] == $receiverId ? 'left' : 'right' }}">
								<div class="chat-body">
									<div class="chat-bubble">
										<div class="chat-content">
											<p>{{ $message['message'] ?? '(No message content)' }}</p>
											<span class="chat-time">{{ $message['created_time'] }}</span>
										</div>
										<div class="chat-action-btns">
											<ul>
												<li><a href="#" class="edit-msg"><i class="fa-solid fa-pencil"></i></a></li>
												<li><a href="#" class="del-msg"><i class="fa-regular fa-trash-can"></i></a></li>
											</ul>
										</div>
									</div>
								</div>
							</div>
						@endforeach
					@endif
				</div>
			</div>
		</div>
	</div>
</div>
<div class="chat-footer">
	<div class="message-bar">
		<div class="message-inner">
			<div class="message-area">
			<form id="replyForm">	
				<div class="input-group">
					<input type="hidden" id="receiver_id" value="{{ $receiverId }}">
					<input type="hidden" id="conversation_id" value="{{ $conversationId }}">
					<input type="hidden" id="access_token" value="{{ $pageAccessToken }}">
					<textarea class="form-control" id="message" placeholder="Type your message..."></textarea>
					<button class="btn btn-custom" type="submit"><i class="fa-solid fa-paper-plane"></i></button>
				</div>
			</form>
			</div>
			<p id="responseMessage"></p>
		</div>
	</div>
</div>
