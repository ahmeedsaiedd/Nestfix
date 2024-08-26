@extends('layouts.master')

@section('content')
    <div class="flex justify-between items-center mb-4">
        <!-- Search by Trace ID -->
    </div>
    <div class="overflow-x-auto ml-auto mx-2 mt-4">
        <div class="min-w-full max-w-full flex flex-col items-end ml-4">
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg bg-gray-800 text-black">
                <table class="w-full text-sm text-left text-black divide-y divide-gray-600">
                    <thead class="bg-gray-900 text-xs text-black uppercase tracking-wider">
                        <tr>
                            <!-- Search by Trace ID -->
                            <form id="filter-form" method="GET" action="{{ route('all-tickets') }}" class="flex space-x-2">
                                <!-- Search by Trace ID -->
                                <input type="text" name="trace_id" placeholder="Search by Trace ID"
                                    value="{{ request('trace_id') }}"
                                    class="border border-gray-600 bg-gray-700 text-black rounded-lg px-4 py-2"
                                    oninput="this.form.submit()">

                                <!-- Filter by Status -->
                                <select name="status"
                                    class="border border-gray-600 bg-gray-700 text-black rounded-lg px-4 py-2"
                                    onchange="this.form.submit()">
                                    <option value="">All Statuses</option>
                                    <option value="open" {{ request('status') === 'open' ? 'selected' : '' }}>Open
                                    </option>
                                    <option value="in progress" {{ request('status') === 'in progress' ? 'selected' : '' }}>
                                        In Progress</option>
                                    <option value="solved" {{ request('status') === 'solved' ? 'selected' : '' }}>Solved
                                    </option>
                                    <option value="done" {{ request('status') === 'done' ? 'selected' : '' }}>Done
                                    </option>
                                    <option value="closed" {{ request('status') === 'closed' ? 'selected' : '' }}>Closed
                                    </option>
                                </select>

                                <!-- Sort by Date -->
                                <select name="sort"
                                    class="border border-gray-600 bg-gray-700 text-black rounded-lg px-4 py-2"
                                    onchange="this.form.submit()">
                                    <option value="newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>Newest First
                                    </option>
                                    <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Oldest First
                                    </option>
                                </select>
                            </form>

                        </tr>
                        <tr class="">
                            <!-- Table Headers -->
                            <th scope="col" class="px-6 py-3 text-black">Ticket ID</th>
                            <th scope="col" class="px-6 py-3 text-black">Trace ID</th>
                            <th scope="col" class="px-6 py-3 text-black">Provider Name</th>
                            <th scope="col" class="px-6 py-3 text-black">Issue Category</th>
                            <th scope="col" class="px-6 py-3 text-black">Issue Description</th>
                            <th scope="col" class="px-6 py-3 text-black">Assigned To</th>
                            <th scope="col" class="px-6 py-3 text-black">Priority</th>
                            <th scope="col" class="px-6 py-3 text-black">Status</th>
                            <th scope="col" class="px-6 py-3 text-black">Attachment</th>
                            <th scope="col" class="px-6 py-3 text-black">Created At</th>
                            <th scope="col" class="px-6 py-3 text-black">Closed At</th>
                            <th scope="col" class="px-6 py-3 w-[800px] text-black">Comment</th>
                        </tr>
                    </thead>
                    <tbody id="ticketsTable" class="bg-gray-900 divide-y divide-gray-600">
                        @foreach ($tickets as $ticket)
                            <tr class="hover:bg-gray-700 transition-colors duration-200">
                                <form method="POST" action="{{ route('tickets.update', $ticket->id) }}" class="w-full">
                                    @csrf
                                    @method('PATCH')
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-black">{{ $ticket->id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-black">{{ $ticket->trace_id }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-black">
                                        {{ $ticket->provider_name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-black">
                                        {{ $ticket->issue_category }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-black">
                                        {{ $ticket->issue_description }}</td>
                                        @php
                                        $user = auth()->user();
                                        $isDisabled = ($user->role == 'operator');
                                    @endphp
                                    
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-black">
                                        <select name="assigned_to"
                                            class="border-gray-300 text-sm rounded-lg shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                            {{ $isDisabled ? 'disabled' : '' }}>
                                            <option value="Dev Team" {{ $ticket->assigned_to == 'Dev Team' ? 'selected' : '' }}>Dev Team
                                            </option>
                                            <option value="Wakty Team" {{ $ticket->assigned_to == 'Wakty Team' ? 'selected' : '' }}>Wakty Team
                                            </option>
                                        </select>
                                    </td>
                                    

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-black">{{ $ticket->priority }}
                                    </td>
                                    <td class="px-8 py-4 whitespace-nowrap text-sm text-black">
                                        <select name="status"
                                            class="block w-full border border-gray-600 bg-gray-700 text-black rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition duration-150 ease-in-out">
                                            @if (auth()->user()->role === 'operator')
                                                <option value="open" {{ $ticket->status == 'open' ? 'selected' : '' }}>
                                                    Open</option>
                                                <option value="closed" {{ $ticket->status == 'closed' ? 'selected' : '' }}>
                                                    Closed</option>
                                            @else
                                                <option value="open" {{ $ticket->status == 'open' ? 'selected' : '' }}>
                                                    Open</option>
                                                <option value="in progress"
                                                    {{ $ticket->status == 'in progress' ? 'selected' : '' }}>In Progress
                                                </option>
                                                <option value="solved" {{ $ticket->status == 'solved' ? 'selected' : '' }}>
                                                    Solved</option>
                                                <option value="done" {{ $ticket->status == 'done' ? 'selected' : '' }}>
                                                    Done</option>
                                                <option value="closed" {{ $ticket->status == 'closed' ? 'selected' : '' }}>
                                                    Closed</option>
                                            @endif
                                        </select>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-black">
                                        @if (!empty($ticket->attachments))
                                            @foreach (json_decode($ticket->attachments) as $attachment)
                                                @php
                                                    $filename = basename($attachment);
                                                @endphp
                                                <div>
                                                    <a href="{{ asset('storage/' . $attachment) }}" download>{{ $filename }}</a>
                                                </div>
                                            @endforeach
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-black">
                                        {{ $ticket->created_at->format('Y-m-d H:i') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-black">
                                        {{ $ticket->closed_at ? $ticket->closed_at->format('Y-m-d H:i') : 'N/A' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-black">
                                        <textarea name="comment"
                                            class="comment-input block w-full border border-gray-600 bg-gray-700 text-black rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition duration-150 ease-in-out resize-none"
                                            placeholder="Add a comment">{{ $ticket->comment ?? '' }}</textarea>
                                        <button type="submit"
                                            class="mt-2 px-4 py-2 bg-blue-600 text-white rounded-lg">Save</button>
                                    </td>
                                </form>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
