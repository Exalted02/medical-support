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
					<h3 class="page-title">Channels</h3>
					<ul class="breadcrumb">
						<li class="breadcrumb-item active">Channels</li>
					</ul>
				</div>
			</div>
		</div>
		<!-- /Page Header -->
	
		<div class="row">
			<div class="col-md-12">
				<div class="row">
					<div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
						<div class="card dash-widget">
							<div class="card-body">
								<span class="dash-widget-icon"><img src="{{ asset('front-assets/img/gmail.png') }}"></span>
								<div class="dash-widget-info">
									<span>Google</span>
									<a href="{{route('gmail.auth')}}" class="btn btn-outline-secondary rounded-pill mt-2">Connect</a>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
						<div class="card dash-widget">
							<div class="card-body">
								<span class="dash-widget-icon"><img src="{{ asset('front-assets/img/facebook.png') }}"></span>
								<div class="dash-widget-info">
									<span>Facebook</span>
									<a href="{{route('facebook.auth')}}" class="btn btn-outline-secondary rounded-pill mt-2">Connect</a>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
						<div class="card dash-widget">
							<div class="card-body">
								<span class="dash-widget-icon"><img src="{{ asset('front-assets/img/whatsapp.png') }}"></span>
								<div class="dash-widget-info">
									<span>WhatsApp</span>
									<button type="button" class="btn btn-outline-secondary rounded-pill mt-2">Connect</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection 
@section('scripts')

@endsection
