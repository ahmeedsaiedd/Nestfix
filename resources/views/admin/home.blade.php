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
        
        <!-- Summary Cards -->
        <h4 class="mb-4 text-lg font-semibold text-gray-600 dark:text-gray-300"></h4>
        <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">
            <!-- Card: Created Tickets -->
            <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <div class="p-3 mr-4 text-orange-500 bg-orange-100 rounded-full dark:text-orange-100 dark:bg-orange-500">
                    <i class="fas fa-ticket-alt w-5 h-5"></i> <!-- FontAwesome icon for tickets -->
                </div>
                <div>
                    <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">Created Tickets</p>
                    <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">{{ $ticketCount }}</p>
                </div>
            </div>
            <!-- Card: Unsolved Tickets -->
            <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <div class="p-3 mr-4 text-red-500 bg-red-100 rounded-full dark:text-red-100 dark:bg-red-500">
                    <i class="fas fa-exclamation-triangle w-5 h-5"></i> <!-- FontAwesome icon for issues -->
                </div>
                <div>
                    <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">Unsolved Tickets(Inprogress)</p>
                    <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">{{ $inProgressTicketsCount }}</p>
                </div>
            </div>
            <!-- Card: Solved Tickets -->
            <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <div class="p-3 mr-4 text-green-500 bg-green-100 rounded-full dark:text-green-100 dark:bg-green-500">
                    <i class="fas fa-check-circle w-5 h-5"></i> <!-- FontAwesome icon for solved -->
                </div>
                <div>
                    <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">Solved Tickets</p>
                    <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">{{ $solvedTicketsCount }}</p>
                </div>
            </div>
            <!-- Card: Active Tickets -->
            <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <div class="p-3 mr-4 text-teal-500 bg-teal-100 rounded-full dark:text-teal-100 dark:bg-teal-500">
                    <i class="fas fa-spinner w-5 h-5"></i> <!-- FontAwesome icon for active/processing -->
                </div>
                <div>
                    <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">Active Tickets</p>
                    <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">{{ $activeTicketsCount }}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="grid gap-6 mb-8 md:grid-cols-2">
        <!-- Doughnut/Pie chart -->
        <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
            <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">Tickets Overview</h4>
            <canvas id="pie"></canvas>
            <div class="flex justify-center mt-4 space-x-3 text-sm text-gray-600 dark:text-gray-400">
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
        <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
            <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">Tickets Trend</h4>
            <canvas id="line"></canvas>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Pie Chart
    const pieCtx = document.getElementById('pie').getContext('2d');
    const pieChart = new Chart(pieCtx, {
        type: 'pie',
        data: {
            labels: ['All Tickets', 'In Progress', 'Solved', 'Unsolved', 'Active'],
            datasets: [{
                label: 'Ticket Status',
                data: [
                    {{ $ticketCount }},
                    {{ $inProgressTicketsCount }},
                    {{ $solvedTicketsCount }},
                    {{$inProgressTicketsCount}},
                    {{ $activeTicketsCount }}
                ],
                backgroundColor: [
                    '#0694a2', // Color for All Tickets
                    '#7e3af2', // Color for In Progress
                    '#34d399', // Color for Solved
                    '#f97316', // Color for Unsolved
                    '#ff6384'  // Color for Active
                ],
                borderColor: '#ffffff',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.label || '';
                            if (label) {
                                label += ': ' + context.raw;
                            }
                            return label;
                        }
                    }
                }
            }
        }
    });

    // Line Chart
    const lineCtx = document.getElementById('line').getContext('2d');
    const lineConfig = {
      type: 'line',
      data: {
        labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'], // Replace with actual months or periods
        datasets: [
          {
            label: 'Created Tickets',
            backgroundColor: '#0694a2',
            borderColor: '#0694a2',
            data: [
              {{ $ticketCount['January'] ?? 0 }},
              {{ $ticketCount['February'] ?? 0 }},
              {{ $ticketCount['March'] ?? 0 }},
              {{ $ticketCount['April'] ?? 0 }},
              {{ $ticketCount['May'] ?? 0 }},
              {{ $ticketCount['June'] ?? 0 }},
              {{ $ticketCount['July'] ?? 0 }}
            ],
            fill: false,
          },
          {
            label: 'In Progress Tickets',
            backgroundColor: '#7e3af2',
            borderColor: '#7e3af2',
            data: [
              {{ $inProgressTickets['January'] ?? 0 }},
              {{ $inProgressTickets['February'] ?? 0 }},
              {{ $inProgressTickets['March'] ?? 0 }},
              {{ $inProgressTickets['April'] ?? 0 }},
              {{ $inProgressTickets['May'] ?? 0 }},
              {{ $inProgressTickets['June'] ?? 0 }},
              {{ $inProgressTickets['July'] ?? 0 }}
            ],
            fill: false,
          },
          {
            label: 'Solved Tickets',
            backgroundColor: '#34d399',
            borderColor: '#34d399',
            data: [
              {{ $solvedTickets['January'] ?? 0 }},
              {{ $solvedTickets['February'] ?? 0 }},
              {{ $solvedTickets['March'] ?? 0 }},
              {{ $solvedTickets['April'] ?? 0 }},
              {{ $solvedTickets['May'] ?? 0 }},
              {{ $solvedTickets['June'] ?? 0 }},
              {{ $solvedTickets['July'] ?? 0 }}
            ],
            fill: false,
          },
          {
            label: 'Active Tickets',
            backgroundColor: '#f97316',
            borderColor: '#f97316',
            data: [
              {{ $activeTicketsCount['January'] ?? 0 }},
              {{ $activeTicketsCount['February'] ?? 0 }},
              {{ $activeTicketsCount['March'] ?? 0 }},
              {{ $activeTicketsCount['April'] ?? 0 }},
              {{ $activeTicketsCount['May'] ?? 0 }},
              {{ $activeTicketsCount['June'] ?? 0 }},
              {{ $activeTicketsCount['July'] ?? 0 }}
            ],
            fill: false,
          },
        //   {
        //     label: 'Unsolved Tickets',
        //     backgroundColor: '#ff6384',
        //     borderColor: '#ff6384',
        //     data: [
        //       {{ $inProgressTicketsCount['January'] ?? 0 }},
        //       {{ $inProgressTicketsCount['February'] ?? 0 }},
        //       {{ $inProgressTicketsCount['March'] ?? 0 }},
        //       {{ $inProgressTicketsCount['April'] ?? 0 }},
        //       {{ $inProgressTicketsCount['May'] ?? 0 }},
        //       {{ $inProgressTicketsCount['June'] ?? 0 }},
        //       {{ $inProgressTicketsCount['July'] ?? 0 }}
        //     ],
        //     fill: false,
        //   }
        ],
      },
      options: {
        responsive: true,
        legend: {
          display: true,
        },
        tooltips: {
          mode: 'index',
          intersect: false,
        },
        hover: {
          mode: 'nearest',
          intersect: true,
        },
        scales: {
          x: {
            display: true,
            title: {
              display: true,
              text: 'Month',
            },
          },
          y: {
            display: true,
            title: {
              display: true,
              text: 'Number of Tickets',
            },
          },
        },
      },
    };
    new Chart(lineCtx, lineConfig);
});
</script>

@endsection
