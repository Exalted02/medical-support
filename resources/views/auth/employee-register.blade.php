<x-guest-layout>
    <div class="col-md-6">
		<div class="m_banner-content-2 m_font-poppins">
			<h3 class="text-center">Employee Sign Up</h3>
			<form method="POST" action="{{ route('register') }}">
			@csrf
				<fieldset>
					<div class="m_banner-content-main">
						<label for="fname">First Name</label>
						<input type="text" name="fname" placeholder="Enter Your First Name">
					</div>

					<div class="m_banner-content-main">
						<label for="lname">Last Name</label>
						<input type="text" name="lname" placeholder="Enter Your Last Name">
					</div>

					<div class="m_banner-content-main">
						<label for="email">Email Address</label>
						<input type="email" name="email" placeholder="Enter your Company Email Address">
					</div>

					<div class="m_banner-content-main-2">
						
						<div class="dropdown">
							<label for="number">Department</label>
							<div class="select">
								<span class="selected">Select-Department</span>
								<div class="caret"></div>
							</div>
							<ul class="menu">
								<li>Department-1</li>
								<li>Department-2</li>
								<li>Department-3</li>
								<li class="active">Department-4</li>
							</ul>
						</div>
					</div>

					<div class="m_banner-content-main">
						<label for="text">Create Username</label>
						<input type="text" name="text" placeholder="Enter Username">
					</div>

					<div class="m_banner-content-main">
						<label for="password">Password</label>
						<input type="password" placeholder="Password" id="sign-business-password" required>
					</div>

					<div class="m_banner-content-main">
						<label for="password">Confirm Password</label>
						<input type="password" placeholder="Confirm Password" id="sign-business-confirm_password" required>

					</div>

					<div class="m_banner-content-main-3">
						<input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
						<label for="vehicle1">By selecting Continue, you agree to our  Terms of Service and acknowledge our Privacy Policy.</label>

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
							<a href="#"><img src="{{ url('front-assets/img/google.svg') }}">Sign in with Google</a>
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
				<p>Already an Employee of Besht?  <a href="{{ route('login') }}"> Sign In</a></p>
			</div>
		</div>
	</div>
</x-guest-layout>
