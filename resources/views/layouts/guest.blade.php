<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ __('project_title') }}</title>

        <link rel="stylesheet" type="text/css" href="{{ url('front-assets/support/bootstrap.min.css') }}">
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
        <link rel="shortcut icon" type="image/x-icon" href="{{ url('front-assets/img/favicon.png') }}">
		<link rel="stylesheet" type="text/css" href="{{ url('front-assets/support/style.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ url('front-assets/support/style-1.css') }}">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
	<body>
		<section class="m_banner">
			<div class="m_banner-parent">
				<div class="row">
					<div class="col-md-6">
						<div class="m_banner-content-1 m_font-roboto">
							<div class="m_logo">
								<h4>Logo</h4>
							</div>
							<h1>Empowering Your Health Journey</h1>
							<p>we prioritize your health by providing seamless access to expert medical support and personalized resources, empowering you to take charge of your wellness journey.</p>
							<div class="m_banner-parent-image">
								<img src="{{ url('front-assets/img/front-image.png') }}">
							</div>
						</div>
					</div>
					{{ $slot }}
				</div>				
			</div>
			<div class="m_banner-bottom">
				<div class="m_banner-bottom-image">
					<img src="{{ url('front-assets/img/Group1.png') }}">
				</div>
				<div class="m_banner-bottom-image-1">
					<img src="{{ url('front-assets/img/Rectangle 20143.png') }}">
				</div>
				<div class="m_banner-bottom-image-2">
					<img src="{{ url('front-assets/img/Rectangle 20144.png') }}">
				</div>
			</div>
		</section>	
    </body>
	
</html>
