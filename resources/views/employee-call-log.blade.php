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
											$my_number = '+13104042226';
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

