@extends('layouts.master')

@section('content')

<main class="h-full pb-16 overflow-y-auto">
    <div class="container px-6 mx-auto grid">
        <!-- Export CSV Button -->
        <div class="flex justify-end mb-4 my-6">
            <a href="{{ route('tickets.export') }}" 
               class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-lg shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-150">
                <i class="fas fa-file-csv w-4 h-4 mr-2"></i> <!-- FontAwesome icon for CSV -->
                Export CSV
            </a>
        </div>
        <div class="flex justify-between items-center mb-6">
          <h2 class="text-2xl font-semibold text-gray-700">
              Welcome, {{ Auth::user()->name }}!
          </h2>
      </div>
        <!-- Summary Cards -->
        <h4 class="mb-4 text-lg font-semibold text-gray-600"></h4>
        <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">
            <!-- Card: Created Tickets -->
            <div class="flex items-center p-4 bg-white rounded-lg shadow-xs">
                <div class="p-3 mr-4 text-orange-500 bg-orange-100 rounded-full">
                    <i class="fas fa-ticket-alt w-5 h-5"></i> <!-- FontAwesome icon for tickets -->
                </div>
                <div>
                    <p class="mb-2 text-sm font-medium text-gray-600">Created Tickets</p>
                    <p class="text-lg font-semibold text-gray-700">{{ $ticketCount }}</p>
                </div>
            </div>
            <!-- Card: Unsolved Tickets -->
            <div class="flex items-center p-4 bg-white rounded-lg shadow-xs">
                <div class="p-3 mr-4 text-red-500 bg-red-100 rounded-full">
                    <i class="fas fa-exclamation-triangle w-5 h-5"></i> <!-- FontAwesome icon for issues -->
                </div>
                <div>
                    <p class="mb-2 text-sm font-medium text-gray-600">Unsolved Tickets (In Progress)</p>
                    <p class="text-lg font-semibold text-gray-700">{{ $inProgressTicketsCount }}</p>
                </div>
            </div>
            <!-- Card: Solved Tickets -->
            <div class="flex items-center p-4 bg-white rounded-lg shadow-xs">
                <div class="p-3 mr-4 text-green-500 bg-green-100 rounded-full">
                    <i class="fas fa-check-circle w-5 h-5"></i> <!-- FontAwesome icon for solved -->
                </div>
                <div>
                    <p class="mb-2 text-sm font-medium text-gray-600">Solved Tickets</p>
                    <p class="text-lg font-semibold text-gray-700">{{ $solvedTicketsCount }}</p>
                </div>
            </div>
            <!-- Card: Active Tickets -->
            <div class="flex items-center p-4 bg-white rounded-lg shadow-xs">
                <div class="p-3 mr-4 text-teal-500 bg-teal-100 rounded-full">
                    <i class="fas fa-spinner w-5 h-5"></i> <!-- FontAwesome icon for active/processing -->
                </div>
                <div>
                    <p class="mb-2 text-sm font-medium text-gray-600">Active Tickets</p>
                    <p class="text-lg font-semibold text-gray-700">{{ $activeTicketsCount }}</p>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="grid gap-6 mb-8 md:grid-cols-2">
        <!-- Doughnut/Pie chart -->
        <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs">
            <h4 class="mb-4 font-semibold text-gray-800">Tickets Overview</h4>
            <canvas id="pie"></canvas>
            <div class="flex justify-center mt-4 space-x-3 text-sm text-gray-600">
                <!-- Chart legend -->
                <div class="flex items-center">
                    <span class="inline-block w-3 h-3 mr-1 bg-blue-600 rounded-full"></span>
                    <span>All Tickets</span>
                </div>
                <div class="flex items-center">
                    <span class="inline-block w-3 h-3 mr-1 bg-teal-500 rounded-full"></span>
                    <span>In Progress</span>
                </div>
                <div class="flex items-center">
                    <span class="inline-block w-3 h-3 mr-1 bg-green-500 rounded-full"></span>
                    <span>Solved</span>
                </div>
                <div class="flex items-center">
                    <span class="inline-block w-3 h-3 mr-1 bg-orange-500 rounded-full"></span>
                    <span>Active</span>
                </div>
            </div>
        </div>
        <!-- Line chart -->
        <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs">
            <h4 class="mb-4 font-semibold text-gray-800">Tickets Trend</h4>
            <canvas id="line"></canvas>
        </div>
    </div> --}}
</main>

@endsection
