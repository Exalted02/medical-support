<x-guest-layout>
	<div class="col-md-6 m_banner-content-3">
		<div class="m_banner-content-2 m_font-poppins">
			<h3 class="text-center">Sign In</h3>
			<form method="POST" action="{{ route('login') }}">
			@csrf
				<fieldset>
					<div class="m_banner-content-main">
						<label for="email">Username</label>
						<input type="email" name="email" id="email" placeholder="Enter Your Username" :value="old('email')" required autofocus autocomplete="username">
						<x-input-error :messages="$errors->get('email')" class="mt-2" />
						@if(session('error'))
						<ul class="text-sm text-red-600 space-y-1 mt-2">
							<li>{{ session('error') }}</li>
						</ul>
						@endif
					</div>

					<div class="m_banner-content-main">
						<label for="password">Password</label>
						<input type="password" id="password" name="password" placeholder="Password" required autocomplete="current-password">
						<x-input-error :messages="$errors->get('password')" class="mt-2" />
					</div>
					
					<!-- Remember Me -->
					<div class="text-right">
						@if (Route::has('password.request'))
							<a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request')}}">
								{{ __('Forgot your password?') }}
							</a>
						@endif
					</div>
					<div class="m_banner-content-main-3">
					{{--<input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
						<label for="vehicle1">Remember me</label>--}}
					<input type="checkbox" id="remember_me" name="remember">
					<label for="remember_me">Remember me</label>
					</div>
					<div class="m_button">
						<button type="submit" class="pure-button pure-button-primary">Log In</button>
					</div>
				</fieldset>
				<div class="m_banner-bottom-form">
					<p>or</p>
				</div>				
			</form>
			<div class="m_banner-bottom-2 text-center">
				<div class="row">
					<div class="col-md-6 mt-2 p-l-0">
						<div class="m_banner-bottom-button">
							<a href="{{route('google-login.auth', ['type' => 2])}}"><img src="{{ url('front-assets/img/google.svg') }}">Client Sign in</a>
						</div>
					</div>
					<div class="col-md-6 mt-2 p-r-0">
						<div class="m_banner-bottom-button">
							<a href="#"><img src="{{ url('front-assets/img/apple-logo.svg') }}">Sign in Apple ID</a>
						</div>
					</div>
				</div>
			</div>
			<div class="m_banner-bottom-2 text-center">
				<div class="row">
					<div class="col-md-6 mt-2 p-l-0">
						<div class="m_banner-bottom-button">
							<a href="{{route('google-login.auth', ['type' => 1])}}"><img src="{{ url('front-assets/img/google.svg') }}">Employee Sign in</a>
						</div>
					</div>
					<div class="col-md-6 mt-2 p-r-0">
						<div class="m_banner-bottom-button">
							<a href="#"><img src="{{ url('front-assets/img/apple-logo.svg') }}">Sign in Apple ID</a>
						</div>
					</div>
				</div>
			</div>

			<div class="m_banner-bottom-3 text-center">
				<p>Are you a Client?  <a href="{{ route('client-register') }}"> Sign up</a></p>

				<p class="mt-4">Are you an Employee? <a href="{{ route('employee-register') }}"> Sign up</a></p>
				
				<p class="mt-4">Are you an Patient? <a href="{{ route('patient-request') }}"> Send request</a></p>
			</div>
		</div>
	</div>
</x-guest-layout>
