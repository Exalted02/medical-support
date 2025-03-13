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
					<h3 class="page-title">Facebook Page</h3>
					<ul class="breadcrumb">
						<li class="breadcrumb-item active">Facebook Page</li>
					</ul>
				</div>
			</div>
		</div>
		<!-- /Page Header -->
	
		<div class="row">
			<div class="col-md-12">
				<div class="row justify-content-center mb-4">
					<div class="col-md-3">
						<div class="input-block mb-3">
							<label class="col-form-label">Select Page<span class="text-danger">*</span></label>
							<select class="select" id="pages-dropdown">
								<option value="">Select a page</option>
								@foreach($data['data'] as $val)
									<option value="{{$val['id']}}" data-token="{{$val['access_token']}}">{{$val['name']}}</option>
								@endforeach
							</select>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection 
@section('scripts')
<script>
$(document).ready(function(){
    $("#pages-dropdown").change(function(){
		let pageId = $(this).val(); // Get selected pageId
		let selectedOption = $(this).find(":selected");
		let accessToken = selectedOption.data('token'); // Get selected pageId
		if (pageId) {
			window.location.href = "{{ url('facebook-inboxes') }}/" + pageId + "?access_token=" + accessToken;
		}
	});
});
</script>
@endsection
