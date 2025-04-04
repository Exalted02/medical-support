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
							<span><h3><strong>What is the reason for new chat ?</strong></h3></span>
						</div>
						<div class="grid-details-underline"></div>
						<div class="d-flex flex-wrap gap-2 mt-5">
							@foreach($chat_reasons as $chat_reason)
								<a href="{{ route('open-new-chat', [$chat_reason->id, auth()->user()->id.time()]) }}"><div class="reason-box">
									{{ $chat_reason->reason ?? '' }}
								</div></a>
							@endforeach
						</div>
					</div>
				</div>
				<!-- /reason -->
			</div>
		</div>
	</div>
</div>
@endsection 
@section('scripts')

@endsection
