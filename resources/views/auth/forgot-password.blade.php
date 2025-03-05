<x-guest-layout>
	<div class="col-md-6 m_banner-content-3">
		<div class="m_banner-content-2 m_font-poppins">
			<h3 class="text-center">Forgot password</h3>
			<form method="POST" action="{{ route('password.email') }}">
				@csrf

				<!-- Email Address -->
				<div>
					<x-input-label for="email" :value="__('Email')" />
					<x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" autofocus />
					<x-input-error :messages="$errors->get('email')" class="mt-2" />
				</div>
				
				<div class="m_button">
					<button type="submit" class="pure-button pure-button-primary">{{ __('Email Password Reset Link') }}</button>
				</div>
				{{--<div class="flex items-center justify-end mt-4">
					<x-primary-button>
						{{ __('Email Password Reset Link') }}
					</x-primary-button>
				</div>--}}
			</form>
		</div>
	</div>
</x-guest-layout>
