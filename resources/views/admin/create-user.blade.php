@extends('layouts.master')

@section('content')
    <div class="flex items-center justify-center min-h-screen bg-gray-100">
        <div class="form-container">
            <x-validation-errors class="mb-4" />

            <form method="POST" action="{{ route('users.store') }}">
                @csrf

                <div class="space-y-6">
                    <!-- Name Input -->
                    <div>
                        <x-label for="name" value="{{ __('Name') }}" />
                        <x-input id="name" class="block mt-1 w-full"
                            type="text" name="name" :value="old('name')"
                            required autofocus autocomplete="name" />
                    </div>

                    <!-- Email Input -->
                    <div>
                        <x-label for="email" value="{{ __('Email') }}" />
                        <x-input id="email" class="block mt-1 w-full"
                            type="email" name="email" :value="old('email')"
                            required autocomplete="username" />
                    </div>

                    <!-- Password Input -->
                    <div>
                        <x-label for="password" value="{{ __('Password') }}" />
                        <x-input id="password" class="block mt-1 w-full"
                            type="password" name="password" required
                            autocomplete="new-password" />
                        {{-- <p class="text-sm text-gray-500 mt-1">Password must be at least 8 characters long and include letters and numbers.</p> --}}
                    </div>

                    <!-- Password Confirmation Input -->
                    <div>
                        <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                        <x-input id="password_confirmation" class="block mt-1 w-full"
                            type="password" name="password_confirmation" required
                            autocomplete="new-password" />
                    </div>

                    <!-- Role Selector -->
                    <div>
                        <x-label for="role" value="{{ __('Role') }}" />
                        <select id="role" name="role" class="block mt-1 w-full">
                            <option value="" disabled {{ old('role') ? '' : 'selected' }}>Select a role</option>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="moderator" {{ old('role') == 'moderator' ? 'selected' : '' }}>Moderator</option>
                            <option value="operator" {{ old('role') == 'operator' ? 'selected' : '' }}>Operator</option>
                        </select>
                        <p class="text-sm text-gray-500 mt-1">Select the role that this user will have.</p>
                    </div>

                    <!-- Admin Password Input -->
                    <div>
                        <x-label for="admin_password" value="{{ __('Admin Password') }}" />
                        <x-input id="admin_password" class="block mt-1 w-full"
                            type="password" name="admin_password" required
                            autocomplete="current-password" />
                        <p class="text-sm text-gray-500 mt-1">Please enter your admin password to confirm this action.</p>
                    </div>
                </div>

                <div class="flex items-center justify-between mt-6">
                    <x-button class="bg-blue-600 hover:bg-green-700 focus:ring-green-500 transition duration-150 ease-in-out">
                        {{ __('Create User') }}
                    </x-button>
                </div>
            </form>
        </div>
    </div>
@endsection
