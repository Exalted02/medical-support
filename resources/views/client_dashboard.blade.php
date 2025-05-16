@extends('layouts.app')
@section('content')
@php 
//echo "<pre>";print_r($chats_data);die;

@endphp
		<!-- Chart CSS -->
		<link rel="stylesheet" href="{{ url('front-assets/plugins/morris/morris.css') }}">
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
			<hr>
			<div class="filter-section">
				<ul>
					<li>
						<div class="form-sort client-chat-menu">
							<button type="button" class="client-chat-button active" data-id="open-chats">Open chats</button>  
							<div class="vertical-divider"></div>
							<button type="button" class="client-chat-button" data-id="closed-chats">Closed chats</button>
							<div class="vertical-divider"></div>
							<button type="button" class="client-chat-button">Transffer to supervisor</button>
						</div>
					</li>
					<li>
						<div class="form-sort">
							<a href="{{ route('start-new-chat')}}"><button type="button" class="chat-button">Start new chat</button></a>
						</div>
					</li>
					<li>
						<div class="view-icons">
							<a href="contact-list.html" class="list-view btn btn-link"><i class="las la-list"></i></a>
							<a href="contact-grid.html" class="grid-view btn btn-link active"><i class="las la-th"></i></a>
						</div>
					</li>
				</ul>
			</div>
            
			<div class="row mt-4 chat-list" id="open-chats">
				@foreach($chats_data as $k=>$chats_data_val)
				
				@php 
					$chats = $chats_data_val[0];
					//dd($chats);
					if(isset($chats->chat_feedback_status)){
						if($chats->chat_feedback_status->chat_status == 0){
							$ticket_status = 'open';
						}else{
							$ticket_status = 'close';
						}
					}else{
						$ticket_status = 'open';
					}
				@endphp	
				@if($ticket_status == 'open')
				@php 	
					$sender = App\Models\User::where('id', $chats->receiver_id)->first();
					$issue = App\Models\Chat_reason::where('id', $chats->reason)->first();
				@endphp
				@if($chats->unique_chat_id != null)
				<div class="col-xxl-3 col-xl-4 col-md-6">
					<a href="{{ route('open-new-chat', [$chats->reason, $chats->unique_chat_id]) }}">
					<div class="contact-grid">
						<div class="grid-head">
							<div class="users-profile">
								<h5 class="name-user">Ticket <strong class="text-muted">#{{$k}}</strong></h5>
							</div>
							{{--<div class="active-ticket">Active ticket</div>--}}
							<button type="button" class="btn btn-sm btn-soft-success">Active ticket</button>
						</div>
						<div class="grid-details-underline"></div>
						<div class="grid-body">
							<div class="address-info1 m-t-20">
								<div class="row w-1001">
									<div class="col-md-6">
										<div class="pro-deadline mb-2">
											<div class="text-dark">
												Resident:
											</div>
											<div class="font-weight-bold text-dark">
												<strong>{{ auth()->user()->name }}</strong>
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="pro-deadline mb-2">
											<div class="text-dark">
												Timestamp:
											</div>
											<div class="font-weight-bold text-dark">
												<strong>{{ \Carbon\Carbon::parse($chats->created_at ?? '')->format('M j Y g:iA') }}</strong>
											</div>
										</div>
									</div>
								</div>
								<div class="row w-1001">
									<div class="col-md-6">
										<div class="pro-deadline mb-2">
											<div class="text-dark">
												Issue :
											</div>
											<div class="font-weight-bold text-dark">
												<strong>{{ $issue->reason ?? ''}}</strong>
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="pro-deadline mb-2">
											<div class="text-dark">
												Assigned to :
											</div>
											<div class="font-weight-bold text-dark">
												<strong>{{ $sender->name ?? '' }}</strong>
											</div>
										</div>
									</div>
								</div>
							</div>
							
						</div>
					</div></a>
				</div>
				@endif
				@endif
				@endforeach
				@if($chats_data->isNotEmpty()) 
				{{--<div class="col-lg-12">
					<div class="load-more-btn text-center">
						<a href="#" class="btn btn-primary">Load More Contacts<i class="spinner-border"></i></a>
					</div>
				</div>--}}
				@endif
			</div>
			<div class="row mt-4 chat-list" id="closed-chats" style="display: none;">
				@foreach($chats_data as $k=>$chats_data_val)
				
				@php 
					$chats = $chats_data_val[0];
					if(isset($chats->chat_feedback_status)){
						if($chats->chat_feedback_status->chat_status == 0){
							$ticket_status = 'open';
						}else{
							$ticket_status = 'close';
						}
					}else{
						$ticket_status = 'open';
					}
				@endphp	
				@if($ticket_status == 'close')
				@php 	
					$sender = App\Models\User::where('id', $chats->receiver_id)->first();
					$issue = App\Models\Chat_reason::where('id', $chats->reason)->first();
				@endphp
				<div class="col-xxl-3 col-xl-4 col-md-6">
					<a href="{{ route('open-new-chat', [$chats->reason, $chats->unique_chat_id]) }}">
					<div class="contact-grid">
						<div class="grid-head">
							<div class="users-profile">
								<h5 class="name-user">Ticket <strong class="text-muted">#{{$k}}</strong></h5>
							</div>
							{{--<div class="active-ticket">Active ticket</div>--}}
							<button type="button" class="btn btn-sm btn-soft-success">Active ticket</button>
						</div>
						<div class="grid-details-underline"></div>
						<div class="grid-body">
							<div class="address-info1 m-t-20">
								<div class="row w-1001">
									<div class="col-md-6">
										<div class="pro-deadline mb-2">
											<div class="text-dark">
												Resident:
											</div>
											<div class="font-weight-bold text-dark">
												<strong>{{ auth()->user()->name }}</strong>
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="pro-deadline mb-2">
											<div class="text-dark">
												Timestamp:
											</div>
											<div class="font-weight-bold text-dark">
												<strong>{{ \Carbon\Carbon::parse($chats->created_at ?? '')->format('M j Y g:iA') }}</strong>
											</div>
										</div>
									</div>
								</div>
								<div class="row w-1001">
									<div class="col-md-6">
										<div class="pro-deadline mb-2">
											<div class="text-dark">
												Issue :
											</div>
											<div class="font-weight-bold text-dark">
												<strong>{{ $issue->reason ?? ''}}</strong>
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="pro-deadline mb-2">
											<div class="text-dark">
												Assigned to :
											</div>
											<div class="font-weight-bold text-dark">
												<strong>{{ $sender->name ?? '' }}</strong>
											</div>
										</div>
									</div>
								</div>
							</div>
							
						</div>
					</div></a>
				</div>
				@endif
				@endforeach
				@if($chats_data->isNotEmpty()) 
				{{--<div class="col-lg-12">
					<div class="load-more-btn text-center">
						<a href="#" class="btn btn-primary">Load More Contacts<i class="spinner-border"></i></a>
					</div>
				</div>--}}
				@endif
			</div>
			{{--<div class="row">
				<div class="col-md-12">
					<div class="card card-table">
						<div class="card-header">
							<h3 class="card-title mb-0">Ongoing Tickets Details</h3>
						</div>
						<div class="card-body">
							<div class="table-responsive">
								<table class="table custom-table mb-0">
									<thead>
										<tr>
											<th>No</th>
											<th>Name</th>
											<th>Query</th>
											<th>Date</th>
											<th>Status</th>
											<th>Query Id</th>
											<th class="text-end">Action</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>1</td>
											<td>Jens Brincker</td>
											<td>Lorem Ipsum is simply dummy text of the printing </td>
											<td>27/05/2016</td>
											<td>
												<span class="badge bg-inverse-danger">Cancelled</span>
											</td>
											<td>101</td>
											<td class="text-end">
												<div class="dropdown dropdown-action">
													<a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
													<div class="dropdown-menu dropdown-menu-right">
														<a class="dropdown-item" href="javascript:void(0)"><i class="fa-solid fa-pencil m-r-5"></i> Edit</a>
														<a class="dropdown-item" href="javascript:void(0)"><i class="fa-regular fa-trash-can m-r-5"></i> Delete</a>
													</div>
												</div>
											</td>
										</tr>
										<tr>
											<td>2</td>
											<td>Mark Hay</td>
											<td>Lorem Ipsum is simply dummy text of the printing </td>
											<td>25/05/2017</td>
											<td>
												<span class="badge bg-inverse-warning">Ongoing</span>
											</td>
											<td>102</td>
											<td class="text-end">
												<div class="dropdown dropdown-action">
													<a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
													<div class="dropdown-menu dropdown-menu-right">
														<a class="dropdown-item" href="javascript:void(0)"><i class="fa-solid fa-pencil m-r-5"></i> Edit</a>
														<a class="dropdown-item" href="javascript:void(0)"><i class="fa-regular fa-trash-can m-r-5"></i> Delete</a>
													</div>
												</div>
											</td>
										</tr>
										<tr>
											<td>3</td>
											<td>Anthony Davie</td>
											<td>Lorem Ipsum is simply dummy text of the printing </td>
											<td>27/05/2017</td>
											<td>
												<span class="badge bg-inverse-success">Solved</span>
											</td>
											<td>103</td>
											<td class="text-end">
												<div class="dropdown dropdown-action">
													<a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
													<div class="dropdown-menu dropdown-menu-right">
														<a class="dropdown-item" href="javascript:void(0)"><i class="fa-solid fa-pencil m-r-5"></i> Edit</a>
														<a class="dropdown-item" href="javascript:void(0)"><i class="fa-regular fa-trash-can m-r-5"></i> Delete</a>
													</div>
												</div>
											</td>
										</tr>
										<tr>
											<td>4</td>
											<td>David Perry</td>
											<td>Lorem Ipsum is simply dummy text of the printing </td>
											<td>20/04/2016</td>
											<td>
												<span class="badge bg-inverse-danger">Cancelled</span>
											</td>
											<td>104</td>
											<td class="text-end">
												<div class="dropdown dropdown-action">
													<a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
													<div class="dropdown-menu dropdown-menu-right">
														<a class="dropdown-item" href="javascript:void(0)"><i class="fa-solid fa-pencil m-r-5"></i> Edit</a>
														<a class="dropdown-item" href="javascript:void(0)"><i class="fa-regular fa-trash-can m-r-5"></i> Delete</a>
													</div>
												</div>
											</td>
										</tr>
										<tr>
											<td>5</td>
											<td>Anthony Davie</td>
											<td>Lorem Ipsum is simply dummy text of the printing </td>
											<td>17/05/2016</td>
											<td>
												<span class="badge bg-inverse-warning">Ongoing</span>
											</td>
											<td>105</td>
											<td class="text-end">
												<div class="dropdown dropdown-action">
													<a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
													<div class="dropdown-menu dropdown-menu-right">
														<a class="dropdown-item" href="javascript:void(0)"><i class="fa-solid fa-pencil m-r-5"></i> Edit</a>
														<a class="dropdown-item" href="javascript:void(0)"><i class="fa-regular fa-trash-can m-r-5"></i> Delete</a>
													</div>
												</div>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class="card-footer">
							<a href="clients.html">View all clients</a>
						</div>
					</div>
				</div>				
			</div>--}}
        </div>
        <!-- /Page Content -->

    </div>
    <!-- /Page Wrapper -->

@endsection 
@section('scripts')
<script src='https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.umd.min.js'></script>
<script src="{{ url('front-assets/js/line-chart-1.js') }}"></script>

<script>
$(document).on('click','.client-chat-button', function(){
	var id = $(this).data('id');
	
	$('.client-chat-button').removeClass('active');
	$(this).addClass('active');
	
	$('.chat-list').hide();
	$('#'+id).show();
	
	
});
/*document.querySelectorAll(".client-chat-button").forEach(button => {
    button.addEventListener("click", function() {
        document.querySelectorAll(".client-chat-button").forEach(btn => btn.classList.remove("active"));
        this.classList.add("active");
    });
});*/
</script>
@endsection

