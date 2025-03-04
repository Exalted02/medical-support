@extends('layouts.app')
@section('content')
<!-- Page Wrapper -->
<div class="page-wrapper">
	<div class="chat-main-row">
		<div class="chat-main-wrapper">
			<div class="col-lg-3 message-view chat-profile-view chat-sidebar" id="task_window">
				<div class="content-full">
					<div class="display-table">
						<div class="table-row">
							<div class="table-body">
								<div class="table-content">
									<div class="chat-user-list">
										<ul class="nav nav-tabs flex-column vertical-tabs-3" role="tablist">
										   <li class="nav-item me-0" role="presentation">
											   <a class="nav-link text-break mw-100 active" data-bs-toggle="tab" role="tab" aria-current="page" href="#employee-vertical" aria-selected="false" tabindex="-1">
												   <i class="feather-message-square me-2 align-middle d-inline-block"></i>Message for finding a good hospitality for health checkup
											   </a>
										   </li>
										   <li class="nav-item me-0" role="presentation">
											   <a class="nav-link text-break mw-100" data-bs-toggle="tab" role="tab" aria-current="page" href="#customers-vertical" aria-selected="false" tabindex="-1">
												   <i class="feather-message-square me-2 align-middle d-inline-block"></i>Employee Two
											   </a>
										   </li>
										   <li class="nav-item me-0" role="presentation">
											   <a class="nav-link text-break mw-100" data-bs-toggle="tab" role="tab" aria-current="page" href="#products-vertical" aria-selected="true">
												   <i class="feather-message-square me-2 align-middle d-inline-block"></i>Employee Three
											   </a>
										   </li>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- /Chat Right Sidebar -->
			<!-- Chats View -->
			<div class="col-lg-9 message-view task-view">
				<div class="chat-window">
					<div class="fixed-header">
						<div class="navbar">
							<div class="user-details me-auto">
								<div class="float-start user-img">
									<a class="avatar" href="profile.html" title="Mike Litorus">
										<img src="{{ url('static-image/avatar-05.jpg') }}" alt="User Image" class="rounded-circle">
										<span class="status online"></span>
									</a>
								</div>
								<div class="user-info float-start">
									<a href="profile.html" title="Mike Litorus"><span>Mike Litorus</span> {{--<i class="typing-text">Typing...</i>--}}</a>
									{{--<span class="last-seen">Last seen today at 7:50 AM</span>--}}
								</div>
							</div>
							<div class="search-box">
								<div class="input-group input-group-sm">
									<input type="text" placeholder="Search" class="form-control">
									<button type="button" class="btn"><i class="fa-solid fa-magnifying-glass"></i></button>
								</div>
							</div>
							<ul class="nav custom-menu">
								<li class="nav-item">
									<a class="nav-link task-chat profile-rightbar float-end" id="task_chat" href="#task_window"><i class="fa-solid fa-user"></i></a>
								</li>
								<li class="nav-item dropdown has-arrow flag-nav">
									<a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="javascript:void(0);" role="button" data-id="en">
									<p><i class="fa-regular fa-circle-dot text-primary me-2"></i>Open</p>
									</a>
									<div class="dropdown-menu dropdown-menu-right">
										<a href="javascript:void(0);" class="dropdown-item" data-id="en">
											<p><i class="fa-regular fa-circle-dot text-primary me-2"></i>Open</p>
										</a>
										<a href="javascript:void(0);" class="dropdown-item" data-id="fr">
											<p><i class="fa-regular fa-circle-dot text-warning me-2"></i>Waiting</p>
										</a>
										<a href="javascript:void(0);" class="dropdown-item" data-id="it">
											<p><i class="fa-regular fa-circle-dot text-success me-2"></i>Resolved</p>
										</a>
									</div>
								</li>
								{{--<li class="nav-item">
									<a href="voice-call.html" class="nav-link"><i class="fa-solid fa-phone"></i></a>
								</li>
								<li class="nav-item">
									<a href="video-call.html" class="nav-link"><i class="fa-solid fa-video"></i></a>
								</li>--}}
								<li class="nav-item dropdown dropdown-action">
									<a aria-expanded="false" data-bs-toggle="dropdown" class="nav-link dropdown-toggle" href="#"><i class="fa-solid fa-gear"></i></a>
									<div class="dropdown-menu dropdown-menu-right">
										<a href="javascript:void(0)" class="dropdown-item">Delete Conversations</a>
										<a href="javascript:void(0)" class="dropdown-item">Settings</a>
									</div>
								</li>
							</ul>
						</div>
					</div>
					<div class="chat-contents">
						<div class="chat-content-wrap">
							<div class="chat-wrap-inner">
								<div class="chat-box">
									<div class="chats">
										<div class="chat chat-right">
											<div class="chat-body">
												<div class="chat-bubble">
													<div class="chat-content">
														<p>Hello. What can I do for you?</p>
														<span class="chat-time">8:30 am</span>
													</div>
													<div class="chat-action-btns">
														<ul>
															<li><a href="#" class="edit-msg"><i class="fa-solid fa-pencil"></i></a></li>
															<li><a href="#" class="del-msg"><i class="fa-regular fa-trash-can"></i></a></li>
														</ul>
													</div>
												</div>
											</div>
										</div>
										<div class="chat-line">
											<span class="chat-date">October 8th, 2018</span>
										</div>
										<div class="chat chat-left">
											<div class="chat-avatar">
												<a href="profile.html" class="avatar">
													<img src="{{ url('static-image/avatar-05.jpg') }}" alt="User Image">
												</a>
											</div>
											<div class="chat-body">
												<div class="chat-bubble">
													<div class="chat-content">
														<p>I'm just looking around.</p>
														<p>Will you tell me something about yourself? </p>
														<span class="chat-time">8:35 am</span>
													</div>
													<div class="chat-action-btns">
														<ul>
															<li><a href="#" class="edit-msg"><i class="fa-solid fa-pencil"></i></a></li>
															<li><a href="#" class="del-msg"><i class="fa-regular fa-trash-can"></i></a></li>
														</ul>
													</div>
												</div>
												<div class="chat-bubble">
													<div class="chat-content">
														<p>Are you there? That time!</p>
														<span class="chat-time">8:40 am</span>
													</div>
													<div class="chat-action-btns">
														<ul>
															<li><a href="#" class="edit-msg"><i class="fa-solid fa-pencil"></i></a></li>
															<li><a href="#" class="del-msg"><i class="fa-regular fa-trash-can"></i></a></li>
														</ul>
													</div>
												</div>
											</div>
										</div>
										<div class="chat chat-right">
											<div class="chat-body">
												<div class="chat-bubble">
													<div class="chat-content">
														<p>Where?</p>
														<span class="chat-time">8:35 am</span>
													</div>
													<div class="chat-action-btns">
														<ul>
															<li><a href="#" class="edit-msg"><i class="fa-solid fa-pencil"></i></a></li>
															<li><a href="#" class="del-msg"><i class="fa-regular fa-trash-can"></i></a></li>
														</ul>
													</div>
												</div>
												<div class="chat-bubble">
													<div class="chat-content">
														<p>OK, my name is Limingqiang. I like singing, playing basketballand so on.</p>
														<span class="chat-time">8:42 am</span>
													</div>
													<div class="chat-action-btns">
														<ul>
															<li><a href="#" class="edit-msg"><i class="fa-solid fa-pencil"></i></a></li>
															<li><a href="#" class="del-msg"><i class="fa-regular fa-trash-can"></i></a></li>
														</ul>
													</div>
												</div>
											</div>
										</div>
										<div class="chat chat-left">
											<div class="chat-avatar">
												<a href="profile.html" class="avatar">
												<img src="{{ url('static-image/avatar-05.jpg') }}" alt="User Image">
												</a>
											</div>
											<div class="chat-body">
												<div class="chat-bubble">
													<div class="chat-content">
														<p>You wait for notice.</p>
														<span class="chat-time">8:30 am</span>
													</div>
													<div class="chat-action-btns">
														<ul>
															<li><a href="#" class="edit-msg"><i class="fa-solid fa-pencil"></i></a></li>
															<li><a href="#" class="del-msg"><i class="fa-regular fa-trash-can"></i></a></li>
														</ul>
													</div>
												</div>
												<div class="chat-bubble">
													<div class="chat-content">
														<p>Consectetuorem ipsum dolor sit?</p>
														<span class="chat-time">8:50 am</span>
													</div>
													<div class="chat-action-btns">
														<ul>
															<li><a href="#" class="edit-msg"><i class="fa-solid fa-pencil"></i></a></li>
															<li><a href="#" class="del-msg"><i class="fa-regular fa-trash-can"></i></a></li>
														</ul>
													</div>
												</div>
												<div class="chat-bubble">
													<div class="chat-content">
														<p>OK?</p>
														<span class="chat-time">8:55 am</span>
													</div>
													<div class="chat-action-btns">
														<ul>
															<li><a href="#" class="edit-msg"><i class="fa-solid fa-pencil"></i></a></li>
															<li><a href="#" class="del-msg"><i class="fa-regular fa-trash-can"></i></a></li>
														</ul>
													</div>
												</div>
												<div class="chat-bubble">
													<div class="chat-content img-content">
														<div class="chat-img-group clearfix">
															<p>Uploaded 3 Images</p>
															<a class="chat-img-attach" href="#">
																<img width="182" height="137" src="{{ url('static-image/placeholder.jpg') }}" alt="Placeholder Image">
																<div class="chat-placeholder">
																	<div class="chat-img-name">placeholder.jpg</div>
																	<div class="chat-file-desc">842 KB</div>
																</div>
															</a>
															<a class="chat-img-attach" href="#">
																<img width="182" height="137" src="{{ url('static-image/placeholder.jpg') }}" alt="Placeholder Image">
																<div class="chat-placeholder">
																	<div class="chat-img-name">842 KB</div>
																</div>
															</a>
															<a class="chat-img-attach" href="#">
																<img width="182" height="137" src="{{ url('static-image/placeholder.jpg') }}" alt="Placeholder Image">
																<div class="chat-placeholder">
																	<div class="chat-img-name">placeholder.jpg</div>
																	<div class="chat-file-desc">842 KB</div>
																</div>
															</a>
														</div>
														<span class="chat-time">9:00 am</span>
													</div>
													<div class="chat-action-btns">
														<ul>
															<li><a href="#" class="edit-msg"><i class="fa-solid fa-pencil"></i></a></li>
															<li><a href="#" class="del-msg"><i class="fa-regular fa-trash-can"></i></a></li>
														</ul>
													</div>
												</div>
											</div>
										</div>
										<div class="chat chat-right">
											<div class="chat-body">
												<div class="chat-bubble">
													<div class="chat-content">
														<p>OK!</p>
														<span class="chat-time">9:00 am</span>
													</div>
													<div class="chat-action-btns">
														<ul>
															<li><a href="#" class="edit-msg"><i class="fa-solid fa-pencil"></i></a></li>
															<li><a href="#" class="del-msg"><i class="fa-regular fa-trash-can"></i></a></li>
														</ul>
													</div>
												</div>
											</div>
										</div>
										<div class="chat chat-left">
											<div class="chat-avatar">
												<a href="profile.html" class="avatar">
													<img src="{{ url('static-image/avatar-05.jpg') }}" alt="User Image">
												</a>
											</div>
											<div class="chat-body">
												<div class="chat-bubble">
													<div class="chat-content">
														<p>Uploaded 3 files</p>
														<ul class="attach-list">
															<li><i class="fa fa-file"></i> <a href="#">example.avi</a></li>
															<li><i class="fa fa-file"></i> <a href="#">activity.psd</a></li>
															<li><i class="fa fa-file"></i> <a href="#">example.psd</a></li>
														</ul>
													</div>
													<div class="chat-action-btns">
														<ul>
															<li><a href="#" class="edit-msg"><i class="fa-solid fa-pencil"></i></a></li>
															<li><a href="#" class="del-msg"><i class="fa-regular fa-trash-can"></i></a></li>
														</ul>
													</div>
												</div>
												<div class="chat-bubble">
													<div class="chat-content">
														<p>Consectetuorem ipsum dolor sit?</p>
														<span class="chat-time">8:50 am</span>
													</div>
													<div class="chat-action-btns">
														<ul>
															<li><a href="#" class="edit-msg"><i class="fa-solid fa-pencil"></i></a></li>
															<li><a href="#" class="del-msg"><i class="fa-regular fa-trash-can"></i></a></li>
														</ul>
													</div>
												</div>
												<div class="chat-bubble">
													<div class="chat-content">
														<p>OK?</p>
														<span class="chat-time">8:55 am</span>
													</div>
													<div class="chat-action-btns">
														<ul>
															<li><a href="#" class="edit-msg"><i class="fa-solid fa-pencil"></i></a></li>
															<li><a href="#" class="del-msg"><i class="fa-regular fa-trash-can"></i></a></li>
														</ul>
													</div>
												</div>
											</div>
										</div>
										<div class="chat chat-right">
											<div class="chat-body">
												<div class="chat-bubble">
													<div class="chat-content img-content">
														<div class="chat-img-group clearfix">
															<p>Uploaded 6 Images</p>
															<a class="chat-img-attach" href="#">
																<img width="182" height="137" src="{{ url('static-image/placeholder.jpg') }}" alt="Placeholder Image">
																<div class="chat-placeholder">
																	<div class="chat-img-name">placeholder.jpg</div>
																	<div class="chat-file-desc">842 KB</div>
																</div>
															</a>
															<a class="chat-img-attach" href="#">
																<img width="182" height="137" src="{{ url('static-image/placeholder.jpg') }}" alt="Placeholder Image">
																<div class="chat-placeholder">
																	<div class="chat-img-name">842 KB</div>
																</div>
															</a>
															<a class="chat-img-attach" href="#">
																<img width="182" height="137" src="{{ url('static-image/placeholder.jpg') }}" alt="Placeholder Image">
																<div class="chat-placeholder">
																	<div class="chat-img-name">placeholder.jpg</div>
																	<div class="chat-file-desc">842 KB</div>
																</div>
															</a>
															<a class="chat-img-attach" href="#">
																<img width="182" height="137" src="{{ url('static-image/placeholder.jpg') }}" alt="Placeholder Image">
																<div class="chat-placeholder">
																	<div class="chat-img-name">placeholder.jpg</div>
																	<div class="chat-file-desc">842 KB</div>
																</div>
															</a>
															<a class="chat-img-attach" href="#">
																<img width="182" height="137" src="{{ url('static-image/placeholder.jpg') }}" alt="Placeholder Image">
																<div class="chat-placeholder">
																	<div class="chat-img-name">placeholder.jpg</div>
																	<div class="chat-file-desc">842 KB</div>
																</div>
															</a>
															<a class="chat-img-attach" href="#">
																<img width="182" height="137" src="{{ url('static-image/placeholder.jpg') }}" alt="Placeholder Image">
																<div class="chat-placeholder">
																	<div class="chat-img-name">placeholder.jpg</div>
																	<div class="chat-file-desc">842 KB</div>
																</div>
															</a>
														</div>
														<span class="chat-time">9:00 am</span>
													</div>
													<div class="chat-action-btns">
														<ul>
															<li><a href="#" class="edit-msg"><i class="fa-solid fa-pencil"></i></a></li>
															<li><a href="#" class="del-msg"><i class="fa-regular fa-trash-can"></i></a></li>
														</ul>
													</div>
												</div>
											</div>
										</div>
										<div class="chat chat-left">
											<div class="chat-avatar">
												<a href="profile.html" class="avatar">
													<img src="{{ url('static-image/avatar-05.jpg') }}" alt="User Image">
												</a>
											</div>
											<div class="chat-body">
												<div class="chat-bubble">
													<div class="chat-content">
														<ul class="attach-list">
															<li class="pdf-file"><i class="fa-regular fa-file-pdf"></i> <a href="#">Document_2016.pdf</a></li>
														</ul>
														<span class="chat-time">9:00 am</span>
													</div>
													<div class="chat-action-btns">
														<ul>
															<li><a href="#" class="edit-msg"><i class="fa-solid fa-pencil"></i></a></li>
															<li><a href="#" class="del-msg"><i class="fa-regular fa-trash-can"></i></a></li>
														</ul>
													</div>
												</div>
											</div>
										</div>	
										<div class="chat chat-right">
											<div class="chat-body">
												<div class="chat-bubble">
													<div class="chat-content">
														<ul class="attach-list">
															<li class="pdf-file"><i class="fa-regular fa-file-pdf"></i> <a href="#">Document_2016.pdf</a></li>
														</ul>
														<span class="chat-time">9:00 am</span>
													</div>
													<div class="chat-action-btns">
														<ul>
															<li><a href="#" class="edit-msg"><i class="fa-solid fa-pencil"></i></a></li>
															<li><a href="#" class="del-msg"><i class="fa-regular fa-trash-can"></i></a></li>
														</ul>
													</div>
												</div>
											</div>
										</div>
										<div class="chat chat-left">
											<div class="chat-avatar">
												<a href="profile.html" class="avatar">
													<img src="{{ url('static-image/avatar-05.jpg') }}" alt="User Image">
												</a>
											</div>
											<div class="chat-body">
												<div class="chat-bubble">
													<div class="chat-content">
														<p>Typing ...</p>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="chat-footer">
						<div class="message-bar">
							<div class="message-inner">
								<a class="link attach-icon" href="#" data-bs-toggle="modal" data-bs-target="#drag_files"><img src="{{ url('static-image/attachment.png') }}" alt="Attachment Icon"></a>
								<div class="message-area">
									<div class="input-group">
										<textarea class="form-control" placeholder="Type message..."></textarea>
										<button class="btn btn-custom" type="button"><i class="fa-solid fa-paper-plane"></i></button>
									</div>
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
