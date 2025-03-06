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
	$(document).on('click','.message-info', function(){
		var ticket_id = $(this).data('ticket');
		var URL = $(this).data('url');
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
});
function get_chat_list()
{
	
}

function validateEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}
