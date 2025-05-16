<ul class="nav nav-tabs flex-column vertical-tabs-3" role="tablist">
	@foreach ($sortedChatUsers as $userId => $messages)
		@php
			//$chatUser = $messages->first()->sender_id == auth()->id() ? $messages->first()->receiver : $messages->first()->sender;
			//$isActive = ($receiverId == $chatUser->id); // Active if receiverId matches
			$firstMessage = $messages->first();
			$senderIds = explode(',', $firstMessage->sender_id);
			$receiverIds = explode(',', $firstMessage->receiver_id);

			if (in_array(auth()->id(), $senderIds)) {
				$chatUser = $firstMessage->receiver;
			} else {
				$chatUser = $firstMessage->sender;
			}
			// $isActive = ($receiverId == $chatUser?->id); // Active only if receiverId matches
			$isActive = ($chat_group_id == $userId); // Active only if receiverId matches
			
			// Check if the user has unread messages
			//$hasUnreadMessages = $messages->where('receiver_id', auth()->id())->where('user_type',1)->where('is_read', 0)->count() > 0;
			
			$hasUnreadMessages = $messages->filter(function ($message) {
				$receiverIds = explode(',', $message->receiver_id);
				return in_array(auth()->id(), $receiverIds)
					&& $message->user_type == 1
					&& $message->is_read == 0;
			})->count() > 0;
		@endphp
		<li class="nav-item me-0" role="presentation">
			<a class="nav-link text-break mw-100 user-link {{ $isActive ? 'active' : '' }} {{ $hasUnreadMessages ? 'unread-message' : '' }}  message-chat-info"
			   href="{{ route('chat', ['receiverId' => $chatUser->id, 'chatGroup' => $userId]) }}"
			   data-userid="{{ $chatUser->id }}"
			  >
				<i class="feather-user me-2 align-middle d-inline-block"></i>
				{{--{{ $chatUser->name }}--}}
				Ticket #{{ $userId }}
			</a>
		</li>
	@endforeach
</ul>