@extends('layouts.app')
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
			<div class="col-md-12">
				<div class="card">
					<div class="card-body">
						<div class="row">
							<div class="col-md-4 col-lg-4 col-sm-6">
								<div class="input-block">
									<label class="col-form-label">{{ __('first_name') }}</label>
									<input class="form-control" type="text" placeholder="{{ __('enter') }} {{ __('first_name') }}">
								</div>
							</div>
							<div class="col-md-4 col-lg-4 col-sm-6">
								<div class="input-block">
									<label class="col-form-label">{{ __('last_name') }}</label>
									<input class="form-control" type="text" placeholder="{{ __('enter') }} {{ __('last_name') }}">
								</div>
							</div>
							<div class="col-md-4 col-lg-4 col-sm-6">
								<div class="input-block">
									<label class="col-form-label">{{ __('email_address') }}</label>
									<input class="form-control" type="text" placeholder="{{ __('enter') }} {{ __('email_address') }}">
								</div>
							</div>
							<div class="col-md-4 col-lg-4 col-sm-6">
								<div class="input-block">
									<label class="col-form-label">{{ __('contact_number') }}</label>
									<input class="form-control" type="text" placeholder="{{ __('enter') }} {{ __('contact_number') }}">
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
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer ">
				<div class="row">
					<div class="col-lg-12 text-end form-wizard-button">
						<button class="button btn-lights reset-btn" type="reset">{{ __('reset') }}</button>
						<button class="btn btn-primary wizard-next-btn" type="button">{{ __('save') }}</button>
					</div>					
				</div>
			</div>
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
@endsection
