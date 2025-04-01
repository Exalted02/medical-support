<x-guest-layout>
    <div class="col-md-6">
		<div class="m_banner-content-2 m_font-poppins">
			<h3 class="text-center">Client Sign Up</h3>
			<form method="POST" action="{{ route('client.register') }}">
			@csrf
				<fieldset>
					<div class="m_banner-content-main">
						<label for="fname">First Name</label>
						<input type="text" name="first_name" placeholder="Enter Your First Name" value="{{ old('first_name', request('first_name')) }}">
						@error('first_name')
							<small class="text-danger d-block">{{ $message }}</small> 
						@enderror
					</div>

					<div class="m_banner-content-main">
						<label for="lname">Last Name</label>
						<input type="text" name="last_name" placeholder="Enter Your Last Name" value="{{ old('last_name', request('last_name')) }}">
						@error('last_name')
							<small class="text-danger d-block">{{ $message }}</small> 
						@enderror
					</div>

					<div class="m_banner-content-main">
						<label for="email">Email Address</label>
						<input type="email" name="email" placeholder="Enter your Company Email Address" value="{{ old('email', request('email')) }}">
						@error('email')
							<small class="text-danger d-block">{{ $message }}</small> 
						@enderror
					</div>

					<div class="m_banner-content-main">
						<label for="tel">Contact Number</label>
						<input type="tel" name="phone_number" placeholder="Enter Contact Number" value="{{ old('phone_number', request('phone_number')) }}">
					</div>

					<div class="m_banner-content-main">
						<label for="number">Fax Number</label>
						<input type="number" name="fax" placeholder="Enter Fax Number" value="{{ old('fax', request('fax')) }}">
					</div>

					<div class="m_banner-content-main-2">
						
						<div class="dropdown">
							<label for="number">Company name</label>
							<select class="select form-control" name="company_name">
								<option value="">Please select</option>
								<option value="1" {{ old('company_name', request('company_name')) == "1" ? 'selected' : 'selected' }}>company1</option>
								<option value="2" {{ old('company_name', request('company_name')) == "2" ? 'selected' : 'selected' }}>company2</option>
								<option value="3" {{ old('company_name', request('company_name')) == "3" ? 'selected' : 'selected' }}>company3</option>
							</select>
						</div>
					</div>

					<div class="m_banner-content-main">
						<label for="text">Create Username</label>
						<input type="text" name="username" placeholder="Enter Username" value="{{ old('username', request('username')) }}">
					</div>

					<div class="m_banner-content-main">
						<label for="password">Password</label>
						<input type="password" name="password" placeholder="Password">
						@error('password')
							<small class="text-danger d-block">{{ $message }}</small> 
						@enderror
					</div>

					<div class="m_banner-content-main">
						<label for="password">Confirm Password</label>
						<input type="password" name="password_confirmation" placeholder="Confirm Password">

					</div>

					<div class="m_banner-content-main-3">
						<input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
						<label for="vehicle1">By selecting Continue, you agree to our Terms of Service and acknowledge our Privacy Policy.</label>

					</div>

					<div class="m_button">
						<button type="submit" class="pure-button pure-button-primary">Sign Up</button>
					</div>

				</fieldset>
				<div class="m_banner-bottom-form">
					<p>or</p>
				</div>				
			</form>
			<div class="m_banner-bottom-2 text-center">
				<div class="row">
					<div class="col-md-6 mt-2">
						<div class="m_banner-bottom-button">
							<a href="{{route('google-login.auth', ['type' => 2])}}"><img src="{{ url('front-assets/img/google.svg') }}">Sign in with Google</a>
						</div>
					</div>
					<div class="col-md-6 mt-2">
						<div class="m_banner-bottom-button">
							<a href="#"><img src="{{ url('front-assets/img/apple-logo.svg') }}">Sign in Apple ID</a>
						</div>
					</div>
				</div>
			</div>

			<div class="m_banner-bottom-3 text-center">
				<p>Already a Client of Besht?  <a href="{{ route('login') }}"> Sign In</a></p>
			</div>
		</div>
	</div>
</x-guest-layout>
