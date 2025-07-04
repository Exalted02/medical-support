<!-- Header -->
<div class="header">

	<!-- Logo -->
	<div class="header-left">
		<a href="{{ route('dashboard')}}" class="logo">
			<img src="{{ asset('front-assets/img/logo.jpg') }}" alt="{{ __('project_title') }}">
		</a>
		<a href="{{ route('dashboard')}}" class="logo collapse-logo">
			<img src="{{ asset('front-assets/img/logo.jpg') }}" alt="{{ __('project_title') }}">
		</a>
		<a href="{{ route('dashboard')}}" class="logo2">
			{{--<img src="{{ asset('front-assets/img/logo.jpg') }}"  alt="{{ __('project_title') }}">--}}
			LOGO
		</a>
	</div>
	<!-- /Logo -->
	
	<a id="toggle_btn" href="javascript:void(0);">
		<span class="bar-icon">
			<span></span>
			<span></span>
			<span></span>
		</span>
	</a>
	
	<!-- Header Title -->
	<div class="page-title-box">
		<h3>{{ __('project_title') }}</h3>
	</div>
	<!-- /Header Title -->
	
	<a id="mobile_btn" class="mobile_btn" href="#sidebar"><i class="fa-solid fa-bars"></i></a>
	
	<!-- Header Menu -->
	<ul class="nav user-menu">
	
		<!-- Search -->
		{{--<li class="nav-item">
			<div class="top-nav-search">
				<a href="javascript:void(0);" class="responsive-search">
					<i class="fa-solid fa-magnifying-glass"></i>
			   </a>
				<form action="search.html">
					<input class="form-control" type="text" placeholder="{{ __('search') }}...">
					<button class="btn" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
				</form>
			</div>
		</li>--}}
		<!-- /Search -->
		<!-- /Generate Ticket -->
		{{--<li class="nav-item m-l-5">
			<button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#generate_ticket">Generate Ticket</button>
		</li>--}}
		<!-- /Generate Ticket -->
		@php
			$selectedLang = session('locale', 'en'); // Default to 'en' if session does not exist
			$languages = [
				'en' => ['text' => 'English', 'flag' => 'us.png'],
				'fr' => ['text' => 'French', 'flag' => 'fr.png'],
				'it' => ['text' => 'Italian', 'flag' => 'it.png'],
				'de' => ['text' => 'German', 'flag' => 'de.png'],
			];
		@endphp
		<!-- Flag -->
		{{--<li class="nav-item dropdown has-arrow flag-nav">
			<a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="javascript:void(0);" role="button" data-id="en">
			<img src="{{ asset('front-assets/img/flags/' . $languages[$selectedLang]['flag']) }}" alt="Flag" height="20">
			<span id="selectedLangText">{{ $languages[$selectedLang]['text'] }}</span>			
			</a>
			<div class="dropdown-menu dropdown-menu-right languageChange">
				<a href="javascript:void(0);" class="dropdown-item" data-id="en">
					<img src="{{ asset('front-assets/img/flags/us.png') }}" alt="Flag" height="16"> English
				</a>
				<a href="javascript:void(0);" class="dropdown-item" data-id="fr">
					<img src="{{ asset('front-assets/img/flags/fr.png') }}" alt="Flag" height="16"> French
				</a>
				<a href="javascript:void(0);" class="dropdown-item" data-id="it">
					<img src="{{ asset('front-assets/img/flags/it.png') }}" alt="Flag" height="16"> Itally
				</a>
				<a href="javascript:void(0);" class="dropdown-item" data-id="de">
					<img src="{{ asset('front-assets/img/flags/de.png') }}" alt="Flag" height="16"> German
				</a>
			</div>
		</li>--}}
		<!-- /Flag -->
	
		<!-- Notifications -->
		{{--<li class="nav-item dropdown">
			<a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
				<i class="fa-regular fa-bell"></i> <span class="badge rounded-pill notify-count">3</span>
			</a>
			<div class="dropdown-menu notifications">
				<div class="topnav-dropdown-header">
					<span class="notification-title">Notifications</span>
					<a href="javascript:void(0)" class="clear-noti"> Clear All </a>
				</div>
				<div class="noti-content">
					<ul class="notification-list">
						<li class="notification-message">
							<a href="activities.html">
								<div class="chat-block d-flex">
									<span class="avatar flex-shrink-0">
										<img src="{{ url('static-image/avatar-02.jpg') }}" alt="User Image">
									</span>
									<div class="media-body flex-grow-1">
										<p class="noti-details"><span class="noti-title">John Doe</span> added new task <span class="noti-title">Patient appointment booking</span></p>
										<p class="noti-time"><span class="notification-time">4 mins ago</span></p>
									</div>
								</div>
							</a>
						</li>
						<li class="notification-message">
							<a href="activities.html">
								<div class="chat-block d-flex">
									<span class="avatar flex-shrink-0">
										<img src="{{ url('static-image/avatar-03.jpg') }}" alt="User Image">
									</span>
									<div class="media-body flex-grow-1">
										<p class="noti-details"><span class="noti-title">Tarah Shropshire</span> changed the task name <span class="noti-title">Appointment booking with payment gateway</span></p>
										<p class="noti-time"><span class="notification-time">6 mins ago</span></p>
									</div>
								</div>
							</a>
						</li>
						<li class="notification-message">
							<a href="activities.html">
								<div class="chat-block d-flex">
									<span class="avatar flex-shrink-0">
										<img src="{{ url('static-image/avatar-06.jpg') }}" alt="User Image">
									</span>
									<div class="media-body flex-grow-1">
										<p class="noti-details"><span class="noti-title">Misty Tison</span> added <span class="noti-title">Domenic Houston</span> and <span class="noti-title">Claire Mapes</span> to project <span class="noti-title">Doctor available module</span></p>
										<p class="noti-time"><span class="notification-time">8 mins ago</span></p>
									</div>
								</div>
							</a>
						</li>
						<li class="notification-message">
							<a href="activities.html">
								<div class="chat-block d-flex">
									<span class="avatar flex-shrink-0">
										<img src="{{ url('static-image/avatar-17.jpg') }}" alt="User Image">
									</span>
									<div class="media-body flex-grow-1">
										<p class="noti-details"><span class="noti-title">Rolland Webber</span> completed task <span class="noti-title">Patient and Doctor video conferencing</span></p>
										<p class="noti-time"><span class="notification-time">12 mins ago</span></p>
									</div>
								</div>
							</a>
						</li>
						<li class="notification-message">
							<a href="activities.html">
								<div class="chat-block d-flex">
									<span class="avatar flex-shrink-0">
										<img src="{{ url('static-image/avatar-13.jpg') }}" alt="User Image">
									</span>
									<div class="media-body flex-grow-1">
										<p class="noti-details"><span class="noti-title">Bernardo Galaviz</span> added new task <span class="noti-title">Private chat module</span></p>
										<p class="noti-time"><span class="notification-time">2 days ago</span></p>
									</div>
								</div>
							</a>
						</li>
					</ul>
				</div>
				<div class="topnav-dropdown-footer">
					<a href="activities.html">View all Notifications</a>
				</div>
			</div>
		</li>--}}
		<!-- /Notifications -->
		
		<!-- Message Notifications -->
		{{--<li class="nav-item dropdown">
			<a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
				<i class="fa-regular fa-comment"></i> <span class="badge rounded-pill">8</span>
			</a>
			<div class="dropdown-menu notifications">
				<div class="topnav-dropdown-header">
					<span class="notification-title">Messages</span>
					<a href="javascript:void(0)" class="clear-noti"> Clear All </a>
				</div>
				<div class="noti-content">
					<ul class="notification-list">
						<li class="notification-message">
							<a href="chat.html">
								<div class="list-item">
									<div class="list-left">
										<span class="avatar">
											<img src="{{ url('static-image/avatar-09.jpg') }}" alt="User Image">
										</span>
									</div>
									<div class="list-body">
										<span class="message-author">Richard Miles </span>
										<span class="message-time">12:28 AM</span>
										<div class="clearfix"></div>
										<span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
									</div>
								</div>
							</a>
						</li>
						<li class="notification-message">
							<a href="chat.html">
								<div class="list-item">
									<div class="list-left">
										<span class="avatar">
											<img src="{{ url('static-image/avatar-02.jpg') }}" alt="User Image">
										</span>
									</div>
									<div class="list-body">
										<span class="message-author">John Doe</span>
										<span class="message-time">6 Mar</span>
										<div class="clearfix"></div>
										<span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
									</div>
								</div>
							</a>
						</li>
						<li class="notification-message">
							<a href="chat.html">
								<div class="list-item">
									<div class="list-left">
										<span class="avatar">
											<img src="{{ url('static-image/avatar-03.jpg') }}" alt="User Image">
										</span>
									</div>
									<div class="list-body">
										<span class="message-author"> Tarah Shropshire </span>
										<span class="message-time">5 Mar</span>
										<div class="clearfix"></div>
										<span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
									</div>
								</div>
							</a>
						</li>
						<li class="notification-message">
							<a href="chat.html">
								<div class="list-item">
									<div class="list-left">
										<span class="avatar">
											<img src="{{ url('static-image/avatar-05.jpg') }}" alt="User Image">
										</span>
									</div>
									<div class="list-body">
										<span class="message-author">Mike Litorus</span>
										<span class="message-time">3 Mar</span>
										<div class="clearfix"></div>
										<span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
									</div>
								</div>
							</a>
						</li>
						<li class="notification-message">
							<a href="chat.html">
								<div class="list-item">
									<div class="list-left">
										<span class="avatar">
											<img src="{{ url('static-image/avatar-08.jpg') }}" alt="User Image">
										</span>
									</div>
									<div class="list-body">
										<span class="message-author"> Catherine Manseau </span>
										<span class="message-time">27 Feb</span>
										<div class="clearfix"></div>
										<span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
									</div>
								</div>
							</a>
						</li>
					</ul>
				</div>
				<div class="topnav-dropdown-footer">
					<a href="chat.html">View all Messages</a>
				</div>
			</div>
		</li>--}}
		<!-- /Message Notifications -->

		<li class="nav-item dropdown has-arrow main-drop">
			<a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
				<span class="user-img"><img src="{{ asset('/front-assets/img/avatar/avatar-19.jpg') }}" class="mt-1" alt="img">
				<span class="status online"></span></span>
				<span>
					@if(auth()->check())
						{{ auth()->user()->name }}
					@endif
				</span>
			</a>
			<div class="dropdown-menu">
				<a class="dropdown-item" href="{{url('my-profile')}}">My Profile</a>
				<a class="dropdown-item" href="{{url('change-password')}}">Change Password</a>
				<a class="dropdown-item" href="{{ route('logout') }}">Logout</a>
			</div>
		</li>
	</ul>
	<!-- /Header Menu -->
	
	<!-- Mobile Menu -->
	<div class="dropdown mobile-user-menu">
		<a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-solid fa-ellipsis-vertical"></i></a>
		<div class="dropdown-menu dropdown-menu-right">
			<a class="dropdown-item" href="profile.html">My Profile</a>
			<a class="dropdown-item" href="settings.html">Settings</a>
			<a class="dropdown-item" href="{{ route('logout') }}">Logout</a>
		</div>
	</div>
	<!-- /Mobile Menu -->
	
</div>
<!-- /Header -->