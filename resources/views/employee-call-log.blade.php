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
                        <h3 class="page-title">Call Log</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->
			<!-- Search Filter -->
			<div class="filter-filelds">
				<form name="search-frm" method="post" action="{{ route('call-log') }}" id="search-call-log">
				@csrf
					<div class="row filter-row">
						<div class="col-xl-4 p-r-0">  
							 <div class="input-block">
								<input type="text" class="form-control date-range bookingrange" name="search_date_range"  id="search_date_range1" placeholder="{{ __('from_to_date')}}" value="{{ $request_date }}" />
							 </div>
						</div>
						<div class="col-xl-2 p-r-0">  
							<button type="submit" class="btn btn-success w-100 search-data"><i class="fa-solid fa-magnifying-glass"></i> Search </button> 
						</div>
					</div>
				</form>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="card card-table">
						<div class="card-header">
							<h3 class="card-title mb-0">Call Logs</h3>
						</div>
						<div class="card-body">
							<div class="table-responsive">
								<table class="table custom-table mb-0">
									<thead>
										<tr>
											<th>S.No</th>
											<th>Type</th>
											<th>From</th>
											<th>To</th>
											<th>Date</th>
											<th>Action</th>
											<th>Result</th>
											<th>Length</th>
										</tr>
									</thead>
									<tbody>
										@php
											$my_number = $user_phone;
											//$type = 'Other';
										@endphp
										@foreach($call_log as $k=>$val)
										@php
											$k++;
											if($my_number == $val->to->phoneNumber){
												$type = 'Inbound';
											}else if($my_number == $val->from->phoneNumber){
												$type = 'Outbound';
											}else{
												$type = 'Other';
											}
										@endphp
										<tr>
											<td>{{ $k }}</td>
											<td>{{ $type }}</td>
											<td>{{ $val->from->phoneNumber }}</td>
											<td>{{ $val->to->phoneNumber }}</td>
											<td>{{ Carbon\Carbon::parse($val->startTime)->format('d M y h:m A') }}</td>
											<td>{{ $val->action }}</td>
											<td>{{ $val->result }}</td>
											<td>{{ change_seconds_format($val->duration) }}</td>
										</tr>
										@endforeach
									</tbody>
								</table>
							</div>
						</div>
						<div class="card-footer">
							<nav>
								<ul class="pagination justify-content-end">
									@if ($page > 1)
									<li class="page-item">
										<a class="page-link" href="{{ url()->current() }}?page={{ $page - 1 }}">Previous</a>
									</li>
									@endif
									
									<li class="page-item active"><a class="page-link" href="#">{{ $page }}</a></li>
									
									@if (!empty($navigation['nextPage']))
									<li class="page-item">
										<a class="page-link" href="{{ url()->current() }}?page={{ $page + 1 }}">Next</a>
									</li>
									@endif
								</ul>
							</nav>
						</div>
					</div>
				</div>				
			</div>
        </div>
        <!-- /Page Content -->

    </div>
    <!-- /Page Wrapper -->

@endsection 
@section('scripts')

@endsection

