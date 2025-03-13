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
	
	
	

    // Function to upload files
   
	
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
	
	$(document).on('click','.update-msg', function(){
		
		var id = $(this).data('id');
		var sender_id = $(this).data('sender');
		var reciever_id = $(this).data('receiver');
		$('#receiverId').val(reciever_id);
		var messageText = $(this).data('msg'); 
		$('#msg').val(messageText);
		$('#mode').val(1);
		$('#edit_id').val(id);
		$('.cross-button').show();
		//alert(messageText);
	});
	
	$(document).on('click','.cross-button', function(){
		$('#edit_id').val('');
		$('#msg').val('');
		$('.cross-button').hide();
		
	});
	$(document).on('click','.del-msg', function(){
		var id = $(this).data('id');
		var className = $(this).data('classname');
		var URL = $(this).data('url');
		//alert(className);
		$.ajax({
			url: URL,
			type: "POST",
			data: {
				id: id,
				_token: csrfToken
			},
			success: function (response) {
				if (response.success) {
					$('.' + className + '[data-id="' + id + '"]').closest('.chat').remove();
					//$('.chat-content[data-id="' + id + '"]').closest('.chat').remove();
				} else {
					alert(response.message);
				}
			},
			error: function () {
				alert("Error deleting message.");
			}
		});
		
	});
	
});


function validateEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}
 
