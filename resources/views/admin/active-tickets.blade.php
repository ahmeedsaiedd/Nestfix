@extends('layouts.master')

@section('content')
    <div class="w-full overflow-hidden rounded-lg shadow-xs">

        <div class="p-4 flex items-center">
            <form method="GET" action="{{ route('active-tickets') }}" class="flex space-x-4 mb-4">
                <input type="text" name="trace_id" id="trace_id" value="{{ request('trace_id') }}"
                    placeholder="Search by Trace ID..." class="px-4 py-2 border border-gray-300 rounded-lg w-1/3">

                <select name="status" id="status"
                    class="px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 hover:bg-gray-100 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">All Statuses</option>
                    @foreach ($statuses as $status)
                        <option value="{{ $status->name }}" {{ request('status') == $status->name ? 'selected' : '' }}>
                            {{ ucfirst($status->name) }}
                        </option>
                    @endforeach
                </select>

                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg">Filter</button>
                <button type="button" class="px-4 py-2 bg-blue-300 text-black rounded-lg"
                    onclick="window.location='{{ route('active-tickets') }}';">Reset</button>
            </form>


            <!-- Export Form, pushed to the right -->
            <div class="ml-auto">
                <form method="GET" action="{{ route('export.active.tickets') }}" class="flex items-center space-x-4">
                    <!-- Pass current filter status and trace_id -->
                    <input type="hidden" name="trace_id" value="{{ request('trace_id') }}">
                    <input type="hidden" name="status" value="{{ request('status') }}">

                    @if ($statuses->isEmpty())
                        <p class="text-red-500 font-semibold">No data to export</p>
                    @else
                        <select name="status" id="export_status" hidden
                            class="px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 hover:bg-gray-100 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">All Statuses</option>
                            @foreach ($statuses as $status)
                                <option value="{{ $status->name }}"
                                    {{ request('status') === $status->name ? 'selected' : '' }}>
                                    {{ ucfirst($status->name) }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit"
                            class="flex items-center justify-center px-4 py-2 text-black rounded-full shadow-lg transform hover:scale-105 hover:bg-gray-800 transition duration-300 ease-in-out focus:outline-none focus:ring-2 focus:ring-gray-500">
                            <span>Export</span>
                            <i class="fa-solid fa-file-export text-lg ml-2"></i> <!-- Margin-left added to create space -->
                        </button>
                    @endif
                </form>

            </div>

        </div>

        <div class="w-full overflow-x-auto">
            <table class="w-full whitespace-no-wrap">
                <thead>
                    <tr class="text-xs font-semibold tracking-wide text-center text-gray-500 uppercase border-b bg-gray-50">
                        <th class="px-4 py-3">Created By</th>
                        <th class="px-4 py-3">Ticket ID</th>
                        <th class="px-4 py-3">Trace ID</th>
                        <th class="px-4 py-3">Provider Name</th>
                        <th class="px-4 py-3">Issue Category</th>
                        <th class="px-4 py-3">Issue Description</th>
                        <th class="px-4 py-3">Assigned To</th>
                        <th class="px-4 py-3">Priority</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Test</th>
                        <th class="px-4 py-3">Environment</th>
                        <th class="px-4 py-3">Comment</th>
                        <th class="px-4 py-3">update</th>
                        <th class="px-4 py-3">delete</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y text-center">
                    @foreach ($tickets as $ticket)
                        <form method="POST" action="{{ route('tickets.update', $ticket->id) }}" class="w-full">
                            @csrf
                            @method('PATCH')
                            <tr class="bg-white text-gray-700">
                                <td class="px-4 py-3 text-sm">
                                    {{ $ticket->creator ? $ticket->creator->name : 'No user assigned' }}
                                </td>

                                <td class="px-4 py-3">{{ $ticket->formatted_id }}</td>
                                <td class="px-4 py-3 text-sm">
                                    @if (!empty($ticket->attachments))
                                        @foreach (json_decode($ticket->attachments) as $attachment)
                                            @php
                                                $filename = basename($attachment);
                                                $traceFilename =
                                                    $ticket->trace_id . '.' . pathinfo($filename, PATHINFO_EXTENSION);
                                            @endphp
                                            <div class="flex items-center space-x-2">
                                                <!-- Font Awesome attachment icon -->
                                                <i class="fas fa-paperclip text-gray-500"></i>
                                                <!-- File link -->
                                                <a href="{{ route('file.download', ['filename' => $filename]) }}" download
                                                    class="text-blue-600 hover:underline">
                                                    {{ $traceFilename }}
                                                </a>
                                            </div>
                                        @endforeach
                                    @else
                                        {{ $ticket->trace_id }}
                                    @endif
                                </td>

                                <td class="px-4 py-3 text-sm">{{ $ticket->provider_name }}</td>
                                <td class="px-4 py-3 text-sm">{{ $ticket->issue_category }}</td>
                                <td class="px-4 py-3 text-sm">{{ $ticket->issue_description }}</td>
                                @php
                                    $user = auth()->user();
                                    $isDisabled = $user->role == 'operator';
                                @endphp
                                <td class="py-6 text-sm w-full">
                                    @if (auth()->user()->role === 'operator')
                                        <span
                                            class="block w-full border border-gray-300 rounded-lg px-4 py-2 text-gray-700 bg-white">
                                            {{ $ticket->assigned_to ?: 'No team assigned' }}
                                        </span>
                                    @else
                                        <select id="assigned_to" name="assigned_to"
                                            class="block w-full border border-gray-300 bg-white text-gray-900 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm p-2"
                                            required>
                                            <option value="" disabled>Select a team</option>
                                            @foreach ($teams as $team)
                                                <option value="{{ $team->name }}"
                                                    {{ $team->name == old('assigned_to', $ticket->assigned_to) ? 'selected' : '' }}>
                                                    {{ $team->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    @endif
                                </td>

                                {{-- <td class="px-4 py-3 text-sm">{{ $ticket->priority }}</td> --}}
                                <td class="py-6 text-sm w-full">
                                    <select name="priority"
                                        class="block w-full border border-gray-300 bg-white text-gray-900 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm p-2">
                                        <option value="high" {{ $ticket->priority == 'high' ? 'selected' : '' }}>High
                                        </option>
                                        <option value="medium" {{ $ticket->priority == 'medium' ? 'selected' : '' }}>Medium
                                        </option>
                                        <option value="low" {{ $ticket->priority == 'low' ? 'selected' : '' }}>Low
                                        </option>
                                    </select>
                                </td>

                                <td class="py-6 text-sm w-full">
                                    <select id="status-select" name="status"
                                        class="block w-full border border-gray-300 bg-white text-gray-900 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm p-1">
                                        @if (auth()->user()->role === 'operator')
                                            <option value="open" {{ $ticket->status === 'open' ? 'selected' : '' }}>Open
                                            </option>
                                            <option value="closed" {{ $ticket->status === 'closed' ? 'selected' : '' }}>
                                                Closed</option>
                                        @else
                                            @foreach ($statuses as $status)
                                                <option value="{{ $status->name }}"
                                                    {{ $ticket->status === $status->name ? 'selected' : '' }}>
                                                    {{ ucfirst($status->name) }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </td>


                                <!-- Display solved_at or closed_at date based on the status -->

                                </td>
                                <td class="px-16 py-3 text-sm">
                                    @php
                                        $userRole = auth()->user()->role;
                                    @endphp

                                    @if ($userRole === 'operator')
                                        <!-- Dropdown for operator -->
                                        <select id="test-select" name="test"
                                            class="block w-full border border-gray-300 bg-white text-black rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition duration-150 ease-in-out">
                                            <option value="solved" {{ $ticket->test === 'solved' ? 'selected' : '' }}>
                                                Solved</option>
                                            <option value="not_solved"
                                                {{ $ticket->test === 'not_solved' ? 'selected' : '' }}>Not Solved</option>
                                        </select>
                                    @else
                                        <!-- Text for admin and moderator -->
                                        <span class="">
                                            {{ !empty($ticket->test) ? ucfirst($ticket->test) : '----' }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{ $ticket->environment }}
                                </td>
                                {{-- <td class="px-2 py-3 text-xs">
                                    @if (!empty($ticket->attachments))
                                        @foreach (json_decode($ticket->attachments) as $attachment)
                                            @php
                                                $filename = basename($attachment);
                                            @endphp
                                            <a href="{{ route('file.download', ['filename' => $filename]) }}" download
                                                class="text-blue-600 hover:underline">
                                                {{ $filename }}
                                            </a>
                                        @endforeach
                                    @else
                                        N/A
                                    @endif
                                </td> --}}
                                {{-- <td class="px-4 py-3 text-sm">{{ $ticket->created_at->format('Y-m-d H:i') }}</td>
                                <td class="px-4 py-3 text-sm">
                                    {{ $ticket->closed_at ? $ticket->closed_at->format('Y-m-d H:i') : 'N/A' }}</td> --}}
                                <td class="py-8 text-sm">
                                    <textarea id="message" name="comment" rows="3" cols="20"
                                        class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                                        placeholder="Add Your Comment">{{ $ticket->comment ?? '' }}</textarea>
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    <form method="POST" action="{{ route('tickets.update', $ticket->id) }}"
                                        class="inline-block">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                            class="px-4 py-2 bg-blue-500 text-white rounded-lg flex items-center space-x-2 mt-0 mb-0">
                                            {{-- <i class="fas fa-edit"></i> --}}
                                            <span>Update</span>
                                        </button>
                                    </form>
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    <form id="delete-form-{{ $ticket->id }}"
                                        action="{{ route('tickets.destroy', $ticket->id) }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                    <button onclick="confirmDelete({{ $ticket->id }})"
                                        class="px-4 py-2 bg-blue-500 text-white rounded-lg flex items-center space-x-2 mt-0 mb-0">
                                        {{-- <i class="fas fa-trash"></i> --}}
                                        <span>Delete</span>
                                    </button>
                                </td>
                            </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    </div>
@endsection
