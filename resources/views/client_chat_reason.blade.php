@extends('layouts.app')
@section('content')
<!-- Page Wrapper -->
<div class="page-wrapper">    
	<!-- Page Content -->
	<div class="content container-fluid pb-0">        
		<!-- Page Header -->
		<div class="page-header">
			<div class="row">
				<div class="col-sm-12">
					<h3 class="page-title">Client Dashboard</h3>
					<ul class="breadcrumb">
						<li class="breadcrumb-item active">Dashboard</li>
					</ul>
				</div>
			</div>
		</div>
		<!-- /Page Header -->
	
		<div class="row">
			<div class="col-md-12">
				<!-- reason -->
				<div class="card leave-box">
					<div class="card-body">
						<div class="row">
							<div class="col-md-6"><span><h3><strong>What is the reason for new chat ?</strong></h3></span></div>
							{{--<div class="col-md-6 text-end"><button type="button" class="chat-button m-0 add-reason">Add New Reasoon</button></div>--}}
						</div>
						<div class="grid-details-underline"></div>
						<div class="d-flex flex-wrap gap-2 mt-5">
							@foreach($chat_reasons[0] as $chat_reason)
								<a href="{{ route('open-new-chat', [$chat_reason->id, auth()->user()->id.time()]) }}"><div class="reason-box">
									{{ $chat_reason->reason ?? '' }}
								</div></a>
							@endforeach
							{{--<a href="javascript:void(0)" id="other-reason"><div class="reason-box">
								Other
							</div></a>--}}
						</div>
						
						<div class="row mt-5">
							<div class="col-md-6"><span><h3><strong>Customer Service /Complaint </strong></h3></span></div>
							{{--<div class="col-md-6 text-end"><button type="button" class="chat-button m-0 add-reason">Add New Reasoon</button></div>--}}
						</div>
						<div class="grid-details-underline"></div>
						<div class="d-flex flex-wrap gap-2 mt-5">
							@foreach($chat_reasons[1] as $chat_reason)
								<a href="{{ route('open-new-chat', [$chat_reason->id, auth()->user()->id.time()]) }}"><div class="reason-box-warning">
									{{ $chat_reason->reason ?? '' }}
								</div></a>
							@endforeach
							{{--<a href="javascript:void(0)" id="other-reason"><div class="reason-box">
								Other
							</div></a>--}}
						</div>
						
						<div class="row mt-5">
							<div class="col-md-6"><span><h3><strong>Urgent Answer  </strong></h3></span></div>
							{{--<div class="col-md-6 text-end"><button type="button" class="chat-button m-0 add-reason">Add New Reasoon</button></div>--}}
						</div>
						<div class="grid-details-underline"></div>
						<div class="d-flex flex-wrap gap-2 mt-5">
							@foreach($chat_reasons[2] as $chat_reason)
								<a href="{{ route('open-new-chat', [$chat_reason->id, auth()->user()->id.time()]) }}"><div class="reason-box-danger">
									{{ $chat_reason->reason ?? '' }}
								</div></a>
							@endforeach
							{{--<a href="javascript:void(0)" id="other-reason"><div class="reason-box">
								Other
							</div></a>--}}
						</div>
					</div>
				</div>
				<!-- /reason -->
			</div>
		</div>
	</div>
</div>


<div id="add_reason" class="modal custom-modal fade" role="dialog">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Create Reason</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="frmReason" action="{{ route('add-new-reason') }}" enctype="multipart/form-data">
					<div class="row">
						<div class="col-sm-12">
							<div class="input-block mb-3">
								<label class="col-form-label">Reason<span class="text-danger">*</span></label>
								<input class="form-control" type="text" name="reason" id="reason" placeholder="Type reason">
								<div class="invalid-feedback"></div>
							</div>
						</div>
					</div>					
					<div class="modal-btn delete-action mt-3">
						<div class="row">
							<div class="col-6">
								<a href="javascript:void(0);" data-bs-dismiss="modal" class="btn btn-sm w-100 btn-secondary">Cancel</a>
							</div>
							<div class="col-6">
								<a href="javascript:void(0);" class="btn btn-sm w-100 btn-primary save-reason">Create <i class="la la-arrow-circle-right"></i></a>
							</div>
						</div>
					</div>
				</form>			
			</div>
		</div>
	</div>
</div>
<div id="other_reason" class="modal custom-modal fade" role="dialog">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Reason</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="frmOtherReason" action="{{ route('add-new-other-reason') }}" enctype="multipart/form-data">
					<div class="row">
						<div class="col-sm-12">
							<div class="input-block mb-3">
								<label class="col-form-label">Reason<span class="text-danger">*</span></label>
								<input class="form-control" type="text" name="other_reason" id="other_reason" placeholder="Type reason">
								<div class="invalid-feedback"></div>
							</div>
						</div>
					</div>					
					<div class="modal-btn delete-action mt-3">
						<div class="row">
							<div class="col-6">
								<a href="javascript:void(0);" data-bs-dismiss="modal" class="btn btn-sm w-100 btn-secondary">Cancel</a>
							</div>
							<div class="col-6">
								<a href="javascript:void(0);" class="btn btn-sm w-100 btn-primary save-other-reason">Next <i class="la la-arrow-circle-right"></i></a>
							</div>
						</div>
					</div>
				</form>			
			</div>
		</div>
	</div>
</div>
<div class="modal custom-modal fade" id="reason_msg" role="dialog">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-body">
				<div class="success-message text-center">
					<div class="success-popup-icon">
						<i class="la la-pencil"></i>
					</div>
					<h3 class="adjust_balance_msg">Updated!!!</h3>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection 
@section('scripts')
<script>
$(document).ready(function() {
	$(document).on('click','.add-reason', function(){
		$('#add_reason').modal('show');
	});
	$(document).on('click','#other-reason', function(){
		$('#other_reason').modal('show');
	});
});
$(document).on('click','.save-other-reason', function(){
	let formData = new FormData($('#frmOtherReason')[0]);
	formData.append('_token', csrfToken);
	var URL = $('#frmOtherReason').attr('action');
	//alert(URL);
	$.ajax({
		url: URL,
		type: "POST",
		data: formData,
		processData: false,  // Required for FormData
		contentType: false,
		//dataType: 'json',
		success: function(response) {
			console.log(response);
			console.log(response.status);
			console.log(response.reason_id);
			console.log(response.chat_url);
			if(response.status === 200){				
				// $('.adjust_balance_msg').text('Reason added successfully.');
				// $('#reason_msg').modal('show');
				window.location.href = response.chat_url;
			}else{
				$('.adjust_balance_msg').text('Reason not added.');
				$('#reason_msg').modal('show');
				setTimeout(() => {
					window.location.reload();
				}, "1000");
			}
		},
		error: function (xhr) {
			if (xhr.status === 422) {
				// alert(xhr.status);
				const errors = xhr.responseJSON.errors;
				$('.invalid-feedback').hide();
				$('.form-control').removeClass('is-invalid');
				
				$.each(errors, function(key, value) {
					// Check the key received from the server
					let fieldName = key.replace(/\./g, '\\.').replace(/\*/g, '');
					let field = $('[name="' + fieldName + '"]');
					
					if (field.length > 0) {
						field.addClass('is-invalid');
						if (field.is('select')) {
							//field.closest('.form-group').find('.invalid-feedback').show().text(value[0]);
							
							field.closest('.input-block').find('.invalid-feedback').show().text(value[0]);
							//alert(value[0]);
						} else {
							field.next('.invalid-feedback').show().text(value[0]);
						}
					} else {
						var fieldNames = key.split('.')[0]; // Get the base field name (e.g., product_sale_price)
						var index = key.split('.').pop();
						var inputField = $('input[name="' + fieldNames + '[]"]').eq(index);
						inputField.addClass('is-invalid');
						inputField.next('.invalid-feedback').show().text(value[0]);
					}
				});
			}else{
				
			}
		}
	});
});
$(document).on('click','.save-reason', function(){
	let formData = new FormData($('#frmReason')[0]);
	formData.append('_token', csrfToken);
	var URL = $('#frmReason').attr('action');
	//alert(URL);
	$.ajax({
		url: URL,
		type: "POST",
		data: formData,
		processData: false,  // Required for FormData
		contentType: false,
		//dataType: 'json',
		success: function(response) {
			console.log(response);
			if(response == 'success'){				
				$('.adjust_balance_msg').text('Reason added successfully.');
			}else{
				$('.adjust_balance_msg').text('Reason not added.');
			}
			$('#reason_msg').modal('show');
			setTimeout(() => {
				window.location.reload();
			}, "1000");
		},
		error: function (xhr) {
			if (xhr.status === 422) {
				// alert(xhr.status);
				const errors = xhr.responseJSON.errors;
				$('.invalid-feedback').hide();
				$('.form-control').removeClass('is-invalid');
				
				$.each(errors, function(key, value) {
					// Check the key received from the server
					let fieldName = key.replace(/\./g, '\\.').replace(/\*/g, '');
					let field = $('[name="' + fieldName + '"]');
					
					if (field.length > 0) {
						field.addClass('is-invalid');
						if (field.is('select')) {
							//field.closest('.form-group').find('.invalid-feedback').show().text(value[0]);
							
							field.closest('.input-block').find('.invalid-feedback').show().text(value[0]);
							//alert(value[0]);
						} else {
							field.next('.invalid-feedback').show().text(value[0]);
						}
					} else {
						var fieldNames = key.split('.')[0]; // Get the base field name (e.g., product_sale_price)
						var index = key.split('.').pop();
						var inputField = $('input[name="' + fieldNames + '[]"]').eq(index);
						inputField.addClass('is-invalid');
						inputField.next('.invalid-feedback').show().text(value[0]);
					}
				});
			}else{
				
			}
		}
	});
});
</script>
@endsection
