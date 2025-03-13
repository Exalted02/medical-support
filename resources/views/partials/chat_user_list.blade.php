<ul class="nav nav-tabs flex-column vertical-tabs-3" role="tablist">
	@foreach ($sortedChatUsers as $userId => $messages)
		@php
			$chatUser = $messages->first()->sender_id == auth()->id()
				? $messages->first()->receiver
				: $messages->first()->sender;
			$isActive = ($receiverId == $chatUser->id); // Active if receiverId matches
			
			// Check if the user has unread messages
			$hasUnreadMessages = $messages->where('receiver_id', auth()->id())->where('user_type',1)->where('is_read', 0)->count() > 0;
		@endphp
		<li class="nav-item me-0" role="presentation">
			<a class="nav-link text-break mw-100 user-link {{ $isActive ? 'active' : '' }}  message-chat-info"
			   href="{{ route('chat', ['receiverId' => $chatUser->id]) }}"
			   data-userid="{{ $chatUser->id }}"
			   style="{{ $hasUnreadMessages ? 'color: black; font-weight: bold;' : '' }}">
				<i class="feather-user me-2 align-middle d-inline-block"></i>
				{{ $chatUser->name }}
			</a>
		</li>
	@endforeach
</ul>