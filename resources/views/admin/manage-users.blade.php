    @extends('layouts.master')

    @section('content')
        <div class="p-6">
            <form action="{{ route('users.index') }}" method="GET" class="mb-4 flex items-center space-x-4">
                <!-- Search Input -->
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name"
                    class="border border-gray-300 rounded-md p-2 text-sm">

                <!-- Role Filter -->
                <select name="role" class="border border-gray-300 rounded-md p-2 text-sm">
                    <option value="">All Roles</option>
                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="moderator" {{ request('role') == 'moderator' ? 'selected' : '' }}>Moderator</option>
                    <option value="operator" {{ request('role') == 'operator' ? 'selected' : '' }}>Operator</option>
                </select>

                <!-- Submit Button -->
                <button type="submit"
                    class="bg-blue-500 text-white p-2 rounded-md text-sm font-semibold hover:bg-blue-600 transition ease-in-out duration-150">
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
                                <th class="px-4 py-3 text-gray-500 text-sm sm:text-base">Change Role</th>
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
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        <div class="flex items-center space-x-4">
                                            <!-- Change Role Form -->
                                            <form action="{{ route('users.changeRole', $user->id) }}" method="POST"
                                                x-data="{ role: '{{ $user->role }}' }" class="flex items-center">
                                                @csrf
                                                @method('PUT')
                                                <select name="role" x-model="role"
                                                    class="border border-gray-300 rounded-md p-2 text-sm">
                                                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin
                                                    </option>
                                                    <option value="moderator"
                                                        {{ $user->role == 'moderator' ? 'selected' : '' }}>Moderator</option>
                                                    <option value="operator" {{ $user->role == 'operator' ? 'selected' : '' }}>
                                                        Operator</option>
                                                </select>
                                                <button type="submit"
                                                    class="ml-2 flex items-center bg-blue-500 text-white p-2 rounded-full text-sm font-semibold hover:bg-blue-600 transition ease-in-out duration-150 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50">
                                                    <i class="fas fa-exchange-alt text-lg"></i>
                                                </button>

                                            </form>

                                            <!-- Reset Password Button -->
                                            <form>
                                                <button type="button"
                                                    class="openModalButton bg-blue-500 text-white p-2 rounded-full text-sm font-semibold hover:bg-blue-600 transition ease-in-out duration-150"
                                                    data-user-id="{{ $user->id }}"
                                                    aria-label="Open Modal">
                                                    <i class="fa-solid fa-key text-lg"></i>
                                                </button>
                                            </form>
                                            



                                            <!-- Delete User Form -->
                                            <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this user?');">
                                              @csrf
                                              @method('DELETE')
                                              <button type="submit"
                                                      class="bg-blue-500 text-white p-2 rounded-full text-sm font-semibold hover:bg-blue-600 transition ease-in-out duration-150 flex items-center justify-center">
                                                  <i class="fa-solid fa-trash text-sm text-white hover:text-blue-200"></i>
                                              </button>
                                          </form>
                                          
                                        </div>

                                        <!-- Password Reset Modal (hidden by default) -->
                                        <div id="passwordResetModal"
                                            class="fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center hidden">
                                            <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-sm relative">
                                                <button id="closeModalButton"
                                                    class="absolute top-2 right-2 text-gray-500 hover:text-gray-700">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                </button>

                                                <!-- Password Reset Form -->
                                                <form id="passwordResetForm" action="{{ route('users.updatePassword') }}"
                                                    method="POST" class="flex flex-col items-center">
                                                    @csrf
                                                    <input type="hidden" id="userId" name="user_id" value="">
                                                    <!-- New Password Field -->
                                                    <div class="mb-4">
                                                        <label for="password"
                                                            class="block text-sm font-medium text-gray-700">New Password</label>
                                                        <input id="password" name="password" type="password" required
                                                            class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm">
                                                    </div>

                                                    <!-- Confirm Password Field -->
                                                    <div class="mb-4">
                                                        <label for="password_confirmation"
                                                            class="block text-sm font-medium text-gray-700">Confirm
                                                            Password</label>
                                                        <input id="password_confirmation" name="password_confirmation"
                                                            type="password" required
                                                            class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm">
                                                    </div>

                                                    <button type="submit"
                                                        class="bg-blue-500 text-white p-2 rounded-full text-sm font-semibold hover:bg-blue-600 transition ease-in-out duration-150">
                                                        Reset Password
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>


                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endsection
