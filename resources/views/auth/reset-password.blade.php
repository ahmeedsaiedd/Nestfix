<head>
    <link rel="icon" href="{{ asset('assets/favicon.png') }}" type="image/png" />

</head>
<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>
        <div class="flex justify-center items-center md:w-1/2 h-32 md:h-auto">
            <!-- Light Mode Image -->
            <img aria-hidden="true" class="object-cover w-30 h-12 dark:hidden"
                 src="{{ asset('assets/EBE_LOGO.png') }}" alt="NestFix Logo">
            
            <!-- Dark Mode Image -->
            <img aria-hidden="true" class="hidden object-cover w-30 h-12 dark:block"
                 src="{{ asset('assets/EBE_LOGO.png') }}" alt="NestFix Logo">
        </div>

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <!-- Use the token passed from the controller -->
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="block">
                <x-label for="email" value="{{ __('Email') }}" />
                <!-- Use the email passed from the controller -->
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $email)" required autofocus autocomplete="username" />
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button>
                    {{ __('Reset Password') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>
