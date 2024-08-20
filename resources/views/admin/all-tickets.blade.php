@extends('layouts.master')

@section('content')
    <div class="overflow-x-auto ml-auto mx-2 mt-16">
        <div class="min-w-full max-w-full flex flex-col items-end ml-4">
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-500 divide-y divide-gray-200">
                    <thead class="bg-gray-50 text-xs text-gray-700 uppercase tracking-wider">
                        <tr>
                            <!-- Table Headers -->
                            <th scope="col" class="px-6 py-3">Ticket ID</th>
                            <th scope="col" class="px-6 py-3">Trace ID</th>
                            <th scope="col" class="px-6 py-3">Provider Name</th>
                            <th scope="col" class="px-6 py-3">Issue Category</th>
                            <th scope="col" class="px-6 py-3">Issue Description</th>
                            <th scope="col" class="px-6 py-3">Assigned To</th>
                            <th scope="col" class="px-6 py-3">Priority</th>
                            <th scope="col" class="px-6 py-3">Status</th>
                            <th scope="col" class="px-6 py-3">Attachment</th>
                            <th scope="col" class="px-6 py-3">Created At</th>
                            <th scope="col" class="px-6 py-3">Closed At</th>
                            <th scope="col" class="px-6 py-3 w-[800px]">Comment</th>
                        </tr>
                    </thead>
                    <tbody id="ticketsTable" class="bg-white divide-y divide-gray-200">
                        @foreach ($tickets as $ticket)
                            <tr class="hover:bg-gray-100 transition-colors duration-200">
                                <form method="POST" action="{{ route('tickets.update', $ticket->id) }}" class="w-full">
                                    @csrf
                                    @method('PATCH')
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $ticket->id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $ticket->trace_id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $ticket->provider_name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $ticket->issue_category }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $ticket->issue_description }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $ticket->assigned_to }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $ticket->priority }}</td>
                                    <td class="px-8 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <select name="status"
                                            class="block w-full border border-gray-300 rounded-lg shadow-sm bg-white text-gray-700 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition duration-150 ease-in-out">
                                            @if(auth()->user()->role === 'operator')
                                                <option value="open" {{ $ticket->status == 'open' ? 'selected' : '' }}>Open</option>
                                                <option value="closed" {{ $ticket->status == 'closed' ? 'selected' : '' }}>Closed</option>
                                            @else
                                                <option value="open" {{ $ticket->status == 'open' ? 'selected' : '' }}>Open</option>
                                                <option value="in progress" {{ $ticket->status == 'in progress' ? 'selected' : '' }}>In Progress</option>
                                                <option value="solved" {{ $ticket->status == 'solved' ? 'selected' : '' }}>Solved</option>
                                                <option value="done" {{ $ticket->status == 'done' ? 'selected' : '' }}>Done</option>
                                                <option value="closed" {{ $ticket->status == 'closed' ? 'selected' : '' }}>Closed</option>
                                            @endif
                                        </select>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $ticket->attachment ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $ticket->created_at->format('Y-m-d H:i') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $ticket->closed_at ? $ticket->closed_at->format('Y-m-d H:i') : 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <textarea name="comment"
                                            class="comment-input block w-full border border-gray-300 rounded-lg shadow-sm bg-white text-gray-700 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition duration-150 ease-in-out resize-none"
                                            placeholder="Add a comment">{{ $ticket->comment ?? '' }}</textarea>
                                        <button type="submit"
                                            class="mt-2 px-4 py-2 bg-blue-500 text-white rounded-lg">Save</button>
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
