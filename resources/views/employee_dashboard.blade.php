@extends('layouts.app')
@section('content')
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
                        <h3 class="page-title">Master Dashboard</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->
        
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
						<div class="col-md-3 col-sm-3 col-lg-3 col-xl-3">
							<div class="card">
								<div class="card-body">
									<div class="d-flex justify-content-between mb-3">
										<div>
											<span class="d-block">Ongoing Queries</span>
										</div>
										{{--<div>
											<span class="text-success">+10%</span>
										</div>--}}
									</div>
									<h3 class="mb-3">125</h3>
									<div class="progress height-five mb-2">
										<div class="progress-bar bg-purple w-70" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
									</div>
									{{--<p class="mb-0">Overall Employees 218</p>--}}
								</div>
							</div>
						</div>
						<div class="col-md-3 col-sm-3 col-lg-3 col-xl-3">
							<div class="card">
								<div class="card-body">
									<div class="d-flex justify-content-between mb-3">
										<div>
											<span class="d-block">Solved Queries</span>
										</div>
										{{--<div>
											<span class="text-success">+10%</span>
										</div>--}}
									</div>
									<h3 class="mb-3">218</h3>
									<div class="progress height-five mb-2">
										<div class="progress-bar bg-danger w-70" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
									</div>
									{{--<p class="mb-0">Overall Employees 218</p>--}}
								</div>
							</div>
						</div>
						<div class="col-md-3 col-sm-3 col-lg-3 col-xl-3">
							<div class="card">
								<div class="card-body">
									<div class="d-flex justify-content-between mb-3">
										<div>
											<span class="d-block">Today's Tickets</span>
										</div>
										{{--<div>
											<span class="text-success">+10%</span>
										</div>--}}
									</div>
									<h3 class="mb-3">25</h3>
									<div class="progress height-five mb-2">
										<div class="progress-bar bg-success w-70" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
									</div>
									{{--<p class="mb-0">Overall Employees 218</p>--}}
								</div>
							</div>
						</div>
						<div class="col-md-3 col-sm-3 col-lg-3 col-xl-3">
							<div class="card">
								<div class="card-body">
									<div class="d-flex justify-content-between mb-3">
										<div>
											<span class="d-block">Total Solved Tickets</span>
										</div>
										{{--<div>
											<span class="text-success">+10%</span>
										</div>--}}
									</div>
									<h3 class="mb-3">2479</h3>
									<div class="progress height-five mb-2">
										<div class="progress-bar bg-warning w-70" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
									</div>
									{{--<p class="mb-0">Overall Employees 218</p>--}}
								</div>
							</div>
						</div>
					</div>
                </div>
            </div>
			<div class="row">
				<div class="col-md-12">
					<div class="row">
						<div class="col-md-6 text-center">
							<div class="card">
								<div class="card-body">
									<h3 class="card-title">Tickets Analytics</h3>
									<canvas id="line-chart" class="w-full m_medi-chart" height="150"></canvas>
								</div>
							</div>
						</div>
						<div class="col-md-6 text-center">
							<div class="card">
								<div class="card-body">
									<h3 class="card-title">Support Provided</h3>
									<canvas id="line-chart-2" class="w-full m_medi-chart" height="150"></canvas>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
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
			</div>
        </div>
        <!-- /Page Content -->

    </div>
    <!-- /Page Wrapper -->

@endsection 
@section('scripts')
<script src='https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.umd.min.js'></script>
<script src="{{ url('front-assets/js/line-chart-1.js') }}"></script>
@endsection

