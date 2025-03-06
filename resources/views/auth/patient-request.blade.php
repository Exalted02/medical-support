<x-guest-layout>
    <div class="col-md-6">
		<div class="m_banner-content-2 m_font-poppins">
			<h3 class="text-center">Patient Request</h3>
			<div class="mt-2 mb-2">
			@if (session('status'))
				<p class="text-success text-center">{{ session('status') }}</p>
			@endif
			</div>
			<form method="POST" action="{{ route('patient-request-send') }}">
			@csrf
				<fieldset>
					<div class="m_banner-content-main">
						<label for="name">Name</label>
						<input type="text" name="name" class="form-control" placeholder="Enter Your Name" value="{{ old('name', request('name')) }}">
						@error('name')
							<small class="text-danger d-block">{{ $message }}</small> 
						@enderror
					</div>

					<div class="m_banner-content-main">
						<label for="email">Email Address</label>
						<input type="email" name="email" class="form-control" placeholder="Enter your Company Email Address" value="{{ old('email', request('email')) }}">
						@error('email')
							<small class="text-danger d-block">{{ $message }}</small> 
						@enderror
					</div>
					
					<div class="m_banner-content-main">
						<label for="phone">Phone no.</label>
						<input type="tel" name="phone" class="form-control" placeholder="Enter Username" value="{{ old('phone', request('phone')) }}">
						@error('phone')
							<small class="text-danger d-block">{{ $message }}</small> 
						@enderror
					</div>

					<div class="m_banner-content-main-2">
						
						<div class="dropdown">
							<label for="number">Department</label>
							<select class="select form-control" name="department">
								<option value="">Please select</option>
								@foreach($departments as $department)
								<option value="{{ $department->id }}" {{ old('department', request('department')) == (string) $department->id ? 'selected' : '' }}>{{ $department->name }}</option>
								@endforeach
							</select>
							@error('department')
							<small class="text-danger d-block">{{ $message }}</small>@enderror
						</div>
					</div>
					
					<div class="m_banner-content-main-2">
						<div class="dropdown">
							<label for="message">Message</label>
							<textarea name="message" class="form-control" placeholder="Enter message" rows="4"></textarea>
							@error('message')
								<small class="text-danger d-block">{{ $message }}</small>
							@enderror
						</div>
					</div>
					<div class="m_button">
						<button type="submit" class="pure-button pure-button-primary">Send request</button>
					</div>
				</fieldset>
			</form>
			{{--<div class="m_banner-bottom-2 text-center">
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
			</div>--}}
		</div>
	</div>
</x-guest-layout>
