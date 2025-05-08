@extends('layouts.app')
@section('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@25.3.1/build/css/intlTelInput.css">
@endsection
@section('content')
<!-- Page Wrapper -->
<div class="page-wrapper">
    <div class="content container">
		<!-- Page Header -->
		<div class="page-header">
			<div class="row align-items-center">
				<div class="col-md-4">
					<h3 class="page-title">{{ __('my_profile') }}</h3>
					<ul class="breadcrumb">
						<li class="breadcrumb-item"><a href="admin-dashboard.html">Dashboard</a></li>
						<li class="breadcrumb-item active">{{ __('edit_profile') }}</li>
					</ul>
				</div>  
			</div>
		</div>
		<!-- /Page Header -->

		<hr>
		<div class="row">
			<form method="post" action="{{ route('my-profile-submit') }}">
			@csrf
				<div class="col-md-12">
					<div class="card">
						<div class="card-body">
							<div class="row">
								<div class="col-md-4 col-lg-4 col-sm-6">
									<div class="input-block">
										<label class="col-form-label">{{ __('first_name') }}</label>
										<input class="form-control" type="text" name="first_name" placeholder="{{ __('enter') }} {{ __('first_name') }}" value="{{ $userData->first_name }}">
										@error('first_name')
										<span class="text-danger">
											{{$message}}		
										</span>
										@enderror
									</div>
								</div>
								<div class="col-md-4 col-lg-4 col-sm-6">
									<div class="input-block">
										<label class="col-form-label">{{ __('last_name') }}</label>
										<input class="form-control" type="text" name="last_name" placeholder="{{ __('enter') }} {{ __('last_name') }}" value="{{ $userData->last_name }}">
										@error('last_name')
										<span class="text-danger">
											{{$message}}		
										</span>
										@enderror
									</div>
								</div>
								<div class="col-md-4 col-lg-4 col-sm-6">
									<div class="input-block">
										<label class="col-form-label">{{ __('contact_number') }}</label>
										<input class="form-control w-100" type="tel" name="contact_number" id="contact_number" placeholder="{{ __('enter') }} {{ __('contact_number') }}" value="{{ $userData->phone_number }}">
										@error('phone_full')
										<span class="text-danger">
											{{$message}}		
										</span>
										@enderror
									</div>
								</div>
								{{--<div class="col-md-4 col-lg-4 col-sm-6">
									<div class="input-block">
										<label class="col-form-label">{{ __('email_address') }}</label>
										<input class="form-control" type="text" placeholder="{{ __('enter') }} {{ __('email_address') }}">
									</div>
								</div>
								<div class="col-md-4 col-lg-4 col-sm-6">
									<div class="input-block">
										<label class="col-form-label">{{ __('fax_number') }}</label>
										<input class="form-control" type="text" placeholder="{{ __('enter') }} {{ __('fax_number') }}">
									</div>
								</div>
								<div class="col-md-4 col-lg-4 col-sm-6">
									<div class="input-block">
										<label class="col-form-label">{{ __('department') }}</label>	
										<select class="select">
											<option>{{ __('select_department') }}</option>
										</select>
									</div>
								</div>--}}
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer ">
					<div class="row">
						<div class="col-lg-12 text-end form-wizard-button">
							<button class="button btn-lights reset-btn" type="reset">{{ __('reset') }}</button>
							<button class="btn btn-primary" type="submit">{{ __('save') }}</button>
						</div>					
					</div>
				</div>
			</form>
		</div>
    </div>
</div>

@endsection 
@section('scripts')
<script src="{{ url('front-assets/js/page/my_profile.js') }}"></script>
<script>
//var csrfToken = "{{ csrf_token() }}";
$( document ).ready(function() {
	if ($.fn.DataTable.isDataTable('.datatable')) {
		$('.datatable').DataTable().destroy(); // Destroy existing instance
	}

	$('.datatable').DataTable({
		//searching: false,
		language: {
			"lengthMenu": "{{ __('Show_MENU_entries') }}",
			"zeroRecords": "{{ __('No records found') }}",
			"info": "{{ __('Showing _START_ to _END_ of _TOTAL_ entries') }}",
			"infoEmpty": "{{ __('No entries available') }}",
			"infoFiltered": "{{ __('(filtered from _MAX_ total entries)') }}",
			"search": "{{ __('search') }}",
			"paginate": {
				"first": "{{ __('First') }}",
				"last": "{{ __('Last') }}",
				"next": "{{ __('Next') }}",
				"previous": "{{ __('Previous') }}"
			},
		}
	});
});
</script>

<script src="https://cdn.jsdelivr.net/npm/intl-tel-input@25.3.1/build/js/intlTelInput.min.js"></script>
<script>
  const input = document.querySelector("#contact_number");
  window.intlTelInput(input, {
    loadUtils: () => import("https://cdn.jsdelivr.net/npm/intl-tel-input@25.3.1/build/js/utils.js"),
	countrySearch:true,
	formatOnDisplay:true,
	separateDialCode: true,
	hiddenInput: () => ({ phone: "phone_full", country: "country_code" }),
  });
</script>
@endsection
