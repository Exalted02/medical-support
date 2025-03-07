<div class="chats">
		<div class="chat-line">
			<span class="chat-date">{{ $tickets->created_at->format('F jS, Y') }}</span>
		</div>
		@if(!empty($tickets->message))
			<div class="chat chat-left">
				<div class="chat-avatar">
					<a href="profile.html" class="avatar">
						<img src="{{ url('static-image/avatar-05.jpg') }}" alt="User Image">
					</a>
				</div>
				<div class="chat-body">
					<div class="chat-bubble">
						<div class="chat-content">
							<p>{{ $tickets->message }}</p>
							
							<span class="chat-time">{{ $tickets->created_at->diffForHumans() }}</span>
						</div>
						<div class="chat-action-btns">
						{{--<ul>
								<li><a href="#" class="edit-msg"><i class="fa-solid fa-pencil"></i></a></li>
								<li><a href="#" class="del-msg"><i class="fa-regular fa-trash-can"></i></a></li>
							</ul>--}}
						</div>
					</div>
					{{--<div class="chat-bubble">
						<div class="chat-content">
							<p>Are you there? That time!</p>
							<span class="chat-time">{{ $tickets->created_at->diffForHumans() }}</span>
						</div>
						<div class="chat-action-btns">
						<ul>
								<li><a href="#" class="edit-msg"><i class="fa-solid fa-pencil"></i></a></li>
								<li><a href="#" class="del-msg"><i class="fa-regular fa-trash-can"></i></a></li>
						</ul>
						</div>
					</div>--}}
				</div>
			</div>
		@endif
			
		@if(!empty($tickets->message_reply))
			<div class="chat chat-right">
				<div class="chat-body">
					<div class="chat-bubble">
						<div class="chat-content">
							<p>{{ $tickets->message_reply }}</p>
							<span class="chat-time">{{ $tickets->updated_at->diffForHumans() }}</span>
						</div>
						<div class="chat-action-btns">
						{{--<ul>
								<li><a href="#" class="edit-msg"><i class="fa-solid fa-pencil"></i></a></li>
								<li><a href="#" class="del-msg"><i class="fa-regular fa-trash-can"></i></a></li>
							</ul>--}}
						</div>
					</div>
				</div>
			</div>
		@endif
	
</div>