/*
Author       : Dreamstechnologies
Template Name: SmartHR - Bootstrap Admin Template
Version      : 4.0
*/

$(document).ready(function() {
	
	setTimeout(function(){
        if ($('.message-info').length > 0) {
            $('.message-info:first').trigger('click');
        }
    }, 500);
	/*setTimeout(function(){
        if ($('.message-chat-info').length > 0) {
            $('.message-chat-info:first').trigger('click');
        }
    }, 500);*/
	
	$(document).on('click','.message-info', function(){
		var ticket_id = $(this).data('ticket');
		var URL = $(this).data('url');
		$('#ticket_id').val(ticket_id);
		$.ajax({
			url: URL,
			type: "POST",
			data: {ticket_id:ticket_id,_token:csrfToken},
			//dataType: 'json',
			success: function(response) {
				//alert(response.html);
				$('#chat-patient-name').html(response.name);
				$('#chat-list-email').html(response.email);
				$('#chat-list-phone').html(response.phone);
				$('#chat-list-div').html(response.html);
			},
		});
	});
	$(document).on('click','.send-message', function(){
		
		var ticket_id = $('#ticket_id').val();
		var message_content = $('#message_content').val();
		var URL = $(this).data('url');
		//alert(URL);alert(ticket_id);alert(message_content);
		if(message_content!='')
		{
			$.ajax({
				url: URL,
				type: "POST",
				data: {ticket_id:ticket_id,message_content:message_content,_token:csrfToken},
				//dataType: 'json',
				success: function(response) {
					//alert(response.ticket_id);
					$('#message_content').val('');
					setTimeout(function(){
						if ($('.message-info').length > 0) {
							$('.message-info[data-ticket="'+ response.ticket_id +'"]').trigger('click');
						}
					}, 500);
				},
			});
		}
	});
	
	
	//var receiverId = {!! json_encode($receiverId) !!}; // Correctly escape Blade variables
    //var authUserId = {!! json_encode(auth()->id()) !!}; // Correctly escape user ID
    var chatBox = $('#chat-messages');
    //var chatBox = $('.chat');

    var pusher = new Pusher("{{ env('PUSHER_APP_KEY') }}", {
        cluster: "{{ env('PUSHER_APP_CLUSTER') }}",
        encrypted: true
    });

    var channel = pusher.subscribe('chat-channel');
    channel.bind('message-sent', function(data) {
        if (data.message.sender_id == authUserId) {
            chatBox.append(`
                <div class="chat chat-right">
                    <div class="chat-body">
                        <div class="chat-bubble">
                            <div class="chat-content">
                                <p>${data.message.message}</p>
                                <span class="chat-time">${new Date().toLocaleTimeString()}</span>
                            </div>
                        </div>
                    </div>
                </div>
            `);
        } else if (data.message.receiver_id == authUserId) {
            chatBox.append(`
                <div class="chat chat-left">
                    <div class="chat-avatar">
                        <a href="#" class="avatar">
                            <img src="{{ url('static-image/avatar-05.jpg') }}" alt="User Image">
                        </a>
                    </div>
                    <div class="chat-body">
                        <div class="chat-bubble">
                            <div class="chat-content">
                                <p>${data.message.message}</p>
                                <span class="chat-time">${new Date().toLocaleTimeString()}</span>
                            </div>
                        </div>
                    </div>
                </div>
            `);
        }
    });
	
	/*$(document).on('click','.message-chat-info', function(){
		let receiverId = $(this).data('userid');
		 alert("hello "+receiverId);
		$('#receiverId').val(receiverId);
	});*/
	
	
	
});
function get_chat_list()
{
	
}

function validateEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}
