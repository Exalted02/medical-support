{{--<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Email Password Reset Link') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>--}}


<x-guest-layout>
	<div class="col-md-6 m_banner-content-3">
		<div class="m_banner-content-2 m_font-poppins">
			<h3 class="text-center">Forgot password</h3>
			<form method="POST" action="{{ route('password.email') }}">
				@csrf

				<!-- Email Address -->
				<div>
					<x-input-label for="email" :value="__('Email')" />
					<x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
					<x-input-error :messages="$errors->get('email')" class="mt-2" />
				</div>

				<div class="flex items-center justify-end mt-4">
					<x-primary-button>
						{{ __('Email Password Reset Link') }}
					</x-primary-button>
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
				<p>Are you a Client?  <a href="{{ route('client-register') }}"> Sign up</a></p>

				<p class="mt-4">Are you an employee? <a href="{{ route('employee-register') }}"> Sign up</a></p>
			</div>
		</div>
	</div>
</x-guest-layout>
