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

					<div class="m_banner-content-main" x-data="{ show: false }">
						<label for="password">Password</label>
						<input :type="show ? 'text' : 'password'" id="password" name="password" placeholder="Password" required autocomplete="current-password">
						<x-input-error :messages="$errors->get('password')" class="mt-2" />
						
						<div class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5 password-view">
							<svg
								x-show="!show"
								@click="show = true"
								xmlns="http://www.w3.org/2000/svg"
								class="h-5 w-5 text-gray-500 cursor-pointer"
								fill="none"
								viewBox="0 0 24 24"
								stroke="currentColor"
							>
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
									  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
									  d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
							</svg>

							<svg
								x-show="show"
								@click="show = false"
								xmlns="http://www.w3.org/2000/svg"
								class="h-5 w-5 text-gray-500 cursor-pointer"
								fill="none"
								viewBox="0 0 24 24"
								stroke="currentColor"
							>
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
									  d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.964 9.964 0 013.113-4.568m1.632-1.287A9.956 9.956 0 0112 5c4.477 0 8.268 2.943 9.542 7a9.965 9.965 0 01-4.293 5.568M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
									  d="M3 3l18 18"/>
							</svg>
						</div>
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
