@extends('layouts.master')

@section('content')
    <div class="w-full overflow-hidden rounded-lg shadow-xs">
        <div class="p-4">
            <!-- Search and Filter Form -->
            <form method="GET" action="{{ route('all-tickets') }}" class="flex space-x-4 mb-4">
                <!-- Search by Trace ID -->
                <input type="text" name="trace_id" value="{{ request('trace_id') }}" placeholder="Search by Trace ID..."
                    class="px-4 py-2 border border-gray-300 rounded-lg w-1/3">

                <!-- Filter by Creation Date (new, old) -->
                <select name="creation_date" class="px-4 py-2 border border-gray-300 rounded-lg">
                    <option value="">All Dates</option>
                    <option value="new" {{ request('creation_date') === 'new' ? 'selected' : '' }}>New</option>
                    <option value="old" {{ request('creation_date') === 'old' ? 'selected' : '' }}>Old</option>
                </select>

                <!-- Filter by Status -->
                <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg">
                    <option value="">All Statuses</option>
                    <option value="open" {{ request('status') === 'open' ? 'selected' : '' }}>Open</option>
                    <option value="closed" {{ request('status') === 'closed' ? 'selected' : '' }}>Closed</option>
                    <!-- Add more status options as needed -->
                </select>

                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg">Filter</button>
            </form>
        </div>
        @endsection