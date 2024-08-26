    <x-guest-layout>
        <x-authentication-card>
            <x-slot name="logo">
            </x-slot>

            <!-- Display Validation Errors -->
            <x-validation-errors class="mb-4" />

            <!-- Display Status Message -->
            @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ session('status') }}
                </div>
            @endif

            <!-- Login Form -->
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="flex flex-col md:flex-row">
                    <!-- Image Section -->
                    <div class="md:w-1/2 h-32 md:h-auto">
                        <img aria-hidden="true" class="object-cover w-full h-full dark:hidden"
                            src="../assets/img/login.jpg" alt="Office" />
                        <img aria-hidden="true" class="hidden object-cover w-full h-full dark:block"
                            src="../assets/img/login.jpg" alt="Office" />
                    </div>

                    <!-- Form Section -->
                    <div class="flex-1 p-6 sm:p-12 md:w-1/2">
                        <div class="w-full">
                            <!-- Email Input -->
                            <div>
                                <x-label for="email" value="{{ __('Email') }}" />
                                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                            </div>

                            <!-- Password Input -->
                            <div class="mt-4">
                                <x-label for="password" value="{{ __('Password') }}" />
                                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
                            </div>

                            <!-- Remember Me Checkbox -->
                            {{-- <div class="block mt-4">
                                <label for="remember_me" class="flex items-center">
                                    <x-checkbox id="remember_me" name="remember" />
                                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                                </label>
                            </div> --}}

                            <!-- Login Button -->
                            <div class="flex items-center justify-between mt-4">
                                <div>
                                    @if (Route::has('password.request'))
                                        <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                                            {{-- {{ __('Forgot your password?') }} --}}
                                        </a>
                                    @endif
                                </div>

                                <x-button class="ml-4">
                                    {{ __('Log in') }}
                                </x-button>
                            </div>

                            <!-- Social Media Buttons -->
                        

                            <!-- Additional Links -->
                        
                        </div>
                    </div>
                </div>
            </form>
        </x-authentication-card>
    </x-guest-layout>
