<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Ticket Dashboard actions -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">
            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Ticket Dashboard</h1>
            </div>
            <!-- Right: Actions -->
            <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
                <a href="{{ route('tickets.create') }}" class="btn bg-violet-500 text-white hover:bg-violet-600">
                    <span>Create Ticket</span>
                </a>
            </div>
        </div>
        <!-- Ticket Stats Cards -->
        <div class="grid grid-cols-12 gap-6 mb-8">
            <div class="col-span-12 sm:col-span-4 xl:col-span-3 bg-white dark:bg-gray-800 shadow-xs rounded-xl p-5">
                <div class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase mb-1">Open Tickets</div>
                <div class="text-3xl font-bold text-gray-800 dark:text-gray-100">{{ $openTickets ?? 0 }}</div>
            </div>
            <div class="col-span-12 sm:col-span-4 xl:col-span-3 bg-white dark:bg-gray-800 shadow-xs rounded-xl p-5">
                <div class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase mb-1">Closed Tickets</div>
                <div class="text-3xl font-bold text-gray-800 dark:text-gray-100">{{ $closedTickets ?? 0 }}</div>
            </div>
            <div class="col-span-12 sm:col-span-4 xl:col-span-3 bg-white dark:bg-gray-800 shadow-xs rounded-xl p-5">
                <div class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase mb-1">Pending Tickets</div>
                <div class="text-3xl font-bold text-gray-800 dark:text-gray-100">{{ $pendingTickets ?? 0 }}</div>
            </div>
            <div class="col-span-12 sm:col-span-4 xl:col-span-3 bg-white dark:bg-gray-800 shadow-xs rounded-xl p-5">
                <div class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase mb-1">Total Tickets</div>
                <div class="text-3xl font-bold text-gray-800 dark:text-gray-100">{{ $totalTickets ?? 0 }}</div>
            </div>
        </div>
        <!-- Quick Links -->
        <div class="mb-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <a href="{{ route('tickets.index') }}" class="block bg-violet-100 dark:bg-violet-900 text-violet-700 dark:text-violet-200 rounded-lg p-4 text-center font-semibold hover:bg-violet-200 dark:hover:bg-violet-800 transition">All Tickets</a>
            <a href="{{ route('tickets.my') }}" class="block bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-200 rounded-lg p-4 text-center font-semibold hover:bg-blue-200 dark:hover:bg-blue-800 transition">My Tickets</a>
            <a href="{{ route('tickets.create') }}" class="block bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-200 rounded-lg p-4 text-center font-semibold hover:bg-green-200 dark:hover:bg-green-800 transition">Create Ticket</a>
            <a href="{{ route('ai.placeholder') }}" class="block bg-gray-100 dark:bg-gray-900 text-gray-700 dark:text-gray-200 rounded-lg p-4 text-center font-semibold hover:bg-gray-200 dark:hover:bg-gray-800 transition">AI & Automations</a>
        </div>
        <!-- Ticket Graphs -->
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <h2 class="text-lg font-semibold mb-4">Tickets Created Over Time</h2>
                <canvas id="ticketsOverTimeChart" height="120"></canvas>
            </div>
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <h2 class="text-lg font-semibold mb-4">Tickets by Status</h2>
                <canvas id="ticketsByStatusChart" height="120"></canvas>
            </div>
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <h2 class="text-lg font-semibold mb-4">Tickets by Category</h2>
                <canvas id="ticketsByCategoryChart" height="120"></canvas>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
        // Placeholder: Replace with AJAX calls to your API endpoints for real data
        function fetchChartData() {
            // Example: Use fetch('/api/ticket-stats')
            return {
                overTime: {
                    labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                    data: [5, 8, 6, 10, 7, 4, 9]
                },
                byStatus: {
                    labels: ['Open', 'Closed', 'Pending'],
                    data: [12, 7, 3]
                },
                byCategory: {
                    labels: ['Hardware', 'Software', 'Network'],
                    data: [8, 10, 4]
                }
            };
        }
        function renderCharts() {
            const chartData = fetchChartData();
            // Tickets Over Time
            new Chart(document.getElementById('ticketsOverTimeChart'), {
                type: 'line',
                data: {
                    labels: chartData.overTime.labels,
                    datasets: [{
                        label: 'Tickets',
                        data: chartData.overTime.data,
                        borderColor: '#7c3aed',
                        backgroundColor: 'rgba(124,58,237,0.1)',
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: { responsive: true, plugins: { legend: { display: false } } }
            });
            // Tickets by Status
            new Chart(document.getElementById('ticketsByStatusChart'), {
                type: 'doughnut',
                data: {
                    labels: chartData.byStatus.labels,
                    datasets: [{
                        data: chartData.byStatus.data,
                        backgroundColor: ['#7c3aed', '#10b981', '#f59e42']
                    }]
                },
                options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
            });
            // Tickets by Category
            new Chart(document.getElementById('ticketsByCategoryChart'), {
                type: 'bar',
                data: {
                    labels: chartData.byCategory.labels,
                    datasets: [{
                        label: 'Tickets',
                        data: chartData.byCategory.data,
                        backgroundColor: '#7c3aed'
                    }]
                },
                options: { responsive: true, plugins: { legend: { display: false } } }
            });
        }
        document.addEventListener('DOMContentLoaded', renderCharts);
        // For real-time: setInterval(renderCharts, 10000); // Poll every 10s
        </script>
    </div>
</x-app-layout>
