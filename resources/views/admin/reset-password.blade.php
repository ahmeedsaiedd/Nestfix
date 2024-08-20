@extends('layouts.master')

@section('content')
<div class="p-6">
    <h2 class="text-xl font-semibold mb-4">Reset Password for {{ $user->name }}</h2>
    <form action="{{ route('users.resetPassword', $user->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label for="password" class="block text-gray-700">New Password</label>
            <input type="password" name="password" id="password" class="form-input mt-1 block w-full" required>
        </div>
        <div class="mb-4">
            <label for="password_confirmation" class="block text-gray-700">Confirm New Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-input mt-1 block w-full" required>
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Reset Password</button>
    </form>
</div>
@endsection
