{{--<x-guest-layout>
    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Reset Password') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>--}}


<x-guest-layout>
	<div class="col-md-6 m_banner-content-3">
		<div class="m_banner-content-2 m_font-poppins">
			<h3 class="text-center">Reset Password</h3>
			<form method="POST" action="{{ route('password.store') }}">
				@csrf

				<!-- Password Reset Token -->
				<input type="hidden" name="token" value="{{ $request->route('token') }}">
				<input type="hidden" name="email" value="exaltedsol04@gmail.com">
				<!-- Email Address -->
				{{--<div>
					<x-input-label for="email" :value="__('Email')" />
					<x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
					<x-input-error :messages="$errors->get('email')" class="mt-2" />
				</div>--}}

				<!-- Password -->
				<div class="mt-4">
					<x-input-label for="password" :value="__('Password')" />
					<x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
					<x-input-error :messages="$errors->get('password')" class="mt-2" />
				</div>

				<!-- Confirm Password -->
				<div class="mt-4">
					<x-input-label for="password_confirmation" :value="__('Confirm Password')" />

					<x-text-input id="password_confirmation" class="block mt-1 w-full"
										type="password"
										name="password_confirmation" required autocomplete="new-password" />

					<x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
				</div>
				<div class="m_button">
					<button type="submit" class="pure-button pure-button-primary">{{ __('Reset Password') }}</button>
				</div>
				{{--<div class="flex items-center justify-end mt-4">
					<x-primary-button>
						{{ __('Reset Password') }}
					</x-primary-button>
				</div>--}}
			</form>
		</div>
	</div>
</x-guest-layout>