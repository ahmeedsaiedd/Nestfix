@extends('layouts.master')

@section('content')
    <div class="w-full overflow-hidden rounded-lg shadow-xs">

        <!-- Search and Filter Form -->
        <div class="p-4 flex items-center justify-between space-x-4">
            <!-- Filter and Export Forms Combined -->
            <div class="flex flex-wrap space-x-4 items-center">
                <!-- Filter Form -->
                <form method="GET" action="{{ route('all-tickets') }}" class="flex items-center space-x-4">
                    <input type="text" name="trace_id" id="trace_id" value="{{ request('trace_id') }}"
                        placeholder="Search by Trace ID..." class="px-4 py-2 border border-gray-300 rounded-lg w-64">

                    <select name="status" id="status"
                        class="px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 hover:bg-gray-100 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">All Statuses</option>
                        @foreach ($statuses as $status)
                            <option value="{{ $status->name }}" {{ request('status') == $status->name ? 'selected' : '' }}>
                                {{ ucfirst($status->name) }}
                            </option>
                        @endforeach
                    </select>

                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500">Filter</button>
                    <button type="button"
                        class="px-4 py-2 bg-gray-300 text-black rounded-lg hover:bg-gray-400 transition-colors focus:outline-none focus:ring-2 focus:ring-gray-500"
                        onclick="window.location='{{ route('all-tickets') }}';">Reset</button>
                </form>

                <!-- Export Form -->
                <form method="GET" action="{{ route('admin.all-tickets') }}" class="flex items-center space-x-4">
                    <!-- Hidden input to trigger export functionality -->
                    <input type="hidden" name="export" value="true">

                    @if ($statuses->isEmpty())
                        <p class="text-red-500 font-semibold">No data to export</p>
                    @else
                        <!-- Hidden select field for filtering by status -->
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

                        <!-- Export CSV button with an awesome icon -->
                        <button type="submit"
                            class="flex items-center justify-center px-4 py-2 text-black rounded-full shadow-lg transform hover:scale-105 hover:bg-gray-800 transition duration-300 ease-in-out focus:outline-none focus:ring-2 focus:ring-gray-500">
                            <span>Export</span>
                            <i class="fa-solid fa-file-export text-lg ml-2"></i> <!-- Margin-left added to create space -->
                        </button>
                    @endif
                </form>


            </div>
        </div>



        <!-- Table -->
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
                    </tr>
                </thead>
                <tbody class="bg-white divide-y text-center">
                    @foreach ($tickets as $ticket)
                        <tr class="text-gray-700">
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
                            <td class="py-6 text-sm w-full">
                                <span class="block w-full rounded-lg px-4 py-2 text-gray-700 bg-white">
                                    {{ $ticket->assigned_to ?: 'No team assigned' }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-sm">
                                <span class="bg-black-200 text-black-700 rounded-lg py-1 px-2">
                                    {{ ucfirst($ticket->priority) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-sm">
                                @if ($ticket->status === 'Solved')
                                    <div class="flex flex-col items-start">
                                        <span
                                            class="px-3 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full">
                                            Solved
                                        </span>
                                        @if ($ticket->solved_at)
                                            <span class="mt-1 text-gray-600 text-sm">
                                                {{ $ticket->solved_at->format('Y-m-d') }}
                                            </span>
                                        @endif
                                    </div>
                                @elseif ($ticket->status === 'Closed')
                                    <div class="flex flex-col items-start">
                                        <span
                                            class="px-3 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-full">
                                            Closed
                                        </span>
                                        @if ($ticket->closed_at)
                                            <span class="mt-1 text-gray-600 text-sm">
                                                {{ $ticket->closed_at->format('Y-m-d') }}
                                            </span>
                                        @endif
                                    </div>
                                @else
                                    <div class="flex flex-col items-start">
                                        <span
                                            class="px-3 py-1 font-semibold leading-tight text-gray-700 bg-gray-100 rounded-full">
                                            {{ ucfirst($ticket->status) }}
                                        </span>
                                    </div>
                                @endif
                            </td>



                            <td class="px-4 py-3 text-sm">
                                <span class="block w-full bg-white text-black rounded-lg px-4 py-2">
                                    {{ !empty($ticket->test) ? ucfirst($ticket->test) : '----' }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-sm">{{ $ticket->environment }}</td>
                            <td class="py-8 text-sm">
                                <p class="block p-2.5 w-full text-sm text-gray-900">{{ $ticket->comment ?? 'No comment' }}
                                </p>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination Links -->
            <div class="p-4">
                {{ $tickets->links() }}
            </div>
        </div>
    </div>
@endsection
