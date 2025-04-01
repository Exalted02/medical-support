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
			
				<div class="col-md-12">
						
					<!-- Annual Leave -->
					<div class="card leave-box">
						<div class="card-body">
							<div class="d-flex flex-wrap gap-2">
								@foreach($chat_reasons as $chat_reason)
									<div class="reason-box">
										{{ $chat_reason->reason ?? '' }}
									</div>
								@endforeach
							</div>
						</div>
					</div>
					<!-- /Annual Leave -->
				</div>
				
			</div>
		</div>
	</div>
</div>
@endsection 
@section('scripts')

@endsection
