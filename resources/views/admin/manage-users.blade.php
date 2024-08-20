@extends('layouts.master')

@section('content')
<div class="p-6">
    <form action="{{ route('users.index') }}" method="GET" class="mb-4 flex items-center space-x-4">
        <!-- Search Input -->
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name" class="border border-gray-300 rounded-md p-2 text-sm">

        <!-- Role Filter -->
        <select name="role" class="border border-gray-300 rounded-md p-2 text-sm">
            <option value="">All Roles</option>
            <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
            <option value="moderator" {{ request('role') == 'moderator' ? 'selected' : '' }}>Moderator</option>
            <option value="operator" {{ request('role') == 'operator' ? 'selected' : '' }}>Operator</option>
        </select>

        <!-- Submit Button -->
        <button type="submit" class="bg-blue-500 text-white p-2 rounded-md text-sm font-semibold hover:bg-blue-600 transition ease-in-out duration-150">
            Search
        </button>
    </form>
    <div class="p-6">
        <div class="overflow-x-auto">
            <table class="w-full bg-white border border-gray-200 rounded-md shadow-md">
                <thead>
                    <tr class="w-full bg-gray-100 border-b border-gray-200 text-left">
                        <th class="px-4 py-3 text-gray-500 text-sm sm:text-base">Name</th>
                        <th class="px-4 py-3 text-gray-500 text-sm sm:text-base">Email</th>
                        <th class="px-4 py-3 text-gray-500 text-sm sm:text-base">Role</th>
                        <th class="px-4 py-3 text-gray-500 text-sm sm:text-base">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr class="hover:bg-gray-50 border-b border-gray-200">
                            <td class="px-4 py-4 text-sm sm:text-base">{{ $user->name }}</td>
                            <td class="px-4 py-4 text-sm sm:text-base">{{ $user->email }}</td>
                            <td class="px-4 py-4 text-sm sm:text-base">
                                <span
                                    class="inline-block px-2 py-1 text-sm font-semibold text-{{ $user->role == 'admin' ? 'red' : ($user->role == 'moderator' ? 'yellow' : 'blue') }}-600 bg-{{ $user->role == 'admin' ? 'red' : ($user->role == 'moderator' ? 'yellow' : 'blue') }}-200 rounded-full">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td
                                class="px-4 py-4 text-sm sm:text-base flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-2">
                                <!-- Change Role Form -->
                                <form action="{{ route('users.changeRole', $user->id) }}" method="POST"
                                    x-data="{ role: '{{ $user->role }}' }" class="flex items-center">
                                    @csrf
                                    @method('PUT')
                                    <select name="role" x-model="role"
                                        class="border border-gray-300 rounded-md p-2 text-sm">
                                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                        <option value="moderator" {{ $user->role == 'moderator' ? 'selected' : '' }}>Moderator</option>
                                        <option value="operator" {{ $user->role == 'operator' ? 'selected' : '' }}>Operator</option>
                                    </select>
                                    <!-- Change Role Button -->
                                    <button type="submit"
                                        class="flex items-center bg-blue-500 text-white p-2 rounded-full text-sm font-semibold hover:bg-blue-600 transition ease-in-out duration-150 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50 group ml-4">
                                        <!-- Font Awesome Icon -->
                                        <i class="fas fa-exchange-alt text-lg"></i>
                                        <!-- Button Text -->
                                        <span class="ml-2 hidden group-hover:inline">Change Role</span>
                                    </button>
                                </form>

                                <!-- Reset Password Button -->
                                <a href="{{ route('users.resetPasswordForm', $user->id) }}"
                                    class="flex items-center bg-blue-500 text-white p-2 rounded-full text-sm font-semibold hover:bg-blue-600 transition ease-in-out duration-150 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50 group ml-4">
                                    <!-- Font Awesome Icon -->
                                    <i class="fas fa-key text-lg"></i>
                                    <!-- Button Text -->
                                    <span class="ml-2 hidden group-hover:inline">Reset Password</span>
                                </a>

                                <!-- Delete Form -->
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="flex items-center">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="flex items-center bg-blue-500 text-white p-2 rounded-full text-sm font-semibold hover:bg-blue-600 transition ease-in-out duration-150 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50 ml-4">
                                        <!-- Font Awesome Icon -->
                                        <i class="fas fa-trash text-lg"></i>
                                        <!-- Button Text -->
                                        <span class="ml-2 hidden group-hover:inline">Delete</span>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
