<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TopFitness Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
    <link href="{{ asset('css/header.css') }}" rel="stylesheet">
    <link href="{{ asset('css/sidebar.css') }}" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
</head>
<body>
    @include ('layouts.header')

    <div class="container-fluid">
        <div class="row">
            @include ('layouts.sidebar')

            <div class="col-md-10">
                <div class="main-content"
                    data-student-genders='@json($studentGenderChart)'
                    data-coach-genders='@json($coachGenderChart)'
                    data-new-users='@json($newUsersChart)'
                    data-revenue='@json($revenueChart)'>

                    <!-- Stats Cards Row -->
                    <div class="row mb-4">
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="stats-card students h-100">
                                <div class="stats-icon"><i class="fas fa-user-graduate"></i></div>
                                <div class="stats-number">{{ $studentCount }}</div>
                                <div class="stats-label">Students</div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="stats-card coaches h-100">
                                <div class="stats-icon"><i class="fas fa-user-tie"></i></div>
                                <div class="stats-number">{{ $coachCount }}</div>
                                <div class="stats-label">Coaches</div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="stats-card exercise h-100">
                                <div class="stats-icon"><i class="fas fa-dumbbell"></i></div>
                                <div class="stats-number">{{ $exerciseCount }}</div>
                                <div class="stats-label">Exercises</div>
                            </div>
                        </div>
                    </div>

                    <!-- Gender & New Users Charts Row -->
                    <div class="row mb-4">
                        <div class="col-lg-4 mb-4">
                            <div class="chart-card h-100">
                                <div class="chart-title">Student Genders</div>
                                <div class="chart-container small">
                                    <canvas id="studentGenderChart"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 mb-4">
                            <div class="chart-card h-100">
                                <div class="chart-title">Coach Genders</div>
                                <div class="chart-container small">
                                    <canvas id="coachGenderChart"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 mb-4">
                            <div class="chart-card h-100">
                                <div class="chart-title">New Users (Last 6 Months)</div>
                                <div class="chart-container small">
                                    <canvas id="newUsersChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Revenue Chart -->
                    <div class="row mb-4">
                        <div class="col-12 mb-4">
                            <div class="chart-card">
                                <div class="chart-title">Revenue (Last 9 Months)</div>
                                <div class="chart-container">
                                    <canvas id="revenueChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Revenue Cards -->
                    <div class="row">
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="revenue-card h-100">
                                <div class="revenue-label">Revenue This Month</div>
                                <div class="revenue-amount">{{ number_format($monthlyRevenue, 2) }} <span class="revenue-currency">USD</span></div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="revenue-card total h-100">
                                <div class="revenue-label">Total Revenue</div>
                                <div class="revenue-amount">{{ number_format($totalRevenue, 2) }} <span class="revenue-currency">USD</span></div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="revenue-card due h-100">
                                <div class="revenue-label">Amount Due to Coaches</div>
                                <div class="revenue-amount">{{ number_format($amountDueToCoaches, 2) }} <span class="revenue-currency">USD</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // --- Get the main content element that holds our data ---
            const mainContent = document.querySelector('.main-content');
            
            // --- Read data from the HTML and parse it into JS Objects ---
            // This is now pure JavaScript, your editor will be happy.
            const studentGenderData = JSON.parse(mainContent.dataset.studentGenders);
            const coachGenderData = JSON.parse(mainContent.dataset.coachGenders);
            const newUsersData = JSON.parse(mainContent.dataset.newUsers);
            const revenueData = JSON.parse(mainContent.dataset.revenue);

            // --- Helper functions for charts (no changes here) ---
            function createDoughnutChart(canvasId, chartData) {
                const canvas = document.getElementById(canvasId);
                if (!canvas) return;
                new Chart(canvas.getContext('2d'), { type: 'doughnut', data: { labels: chartData.labels, datasets: [{ data: chartData.data, backgroundColor: ['#28a745', '#ff6b6b', '#ffc107', '#17a2b8'], borderColor: '#fff', borderWidth: 2 }] }, options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'bottom', labels: { padding: 20, usePointStyle: true } } } } });
            }
            function createBarChart(canvasId, chartData) {
                const canvas = document.getElementById(canvasId);
                if (!canvas) return;
                new Chart(canvas.getContext('2d'), { type: 'bar', data: { labels: chartData.labels, datasets: [{ data: chartData.data, backgroundColor: ['#28a745', '#ff6b6b', '#ffc107', '#17a2b8', '#6f42c1', '#fd7e14'], borderRadius: 5 }] }, options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true }, x: { grid: { display: false } } } } });
            }
            function createLineChart(canvasId, chartData) {
                const canvas = document.getElementById(canvasId);
                if (!canvas) return;
                new Chart(canvas.getContext('2d'), { type: 'line', data: { labels: chartData.labels, datasets: [{ label: 'Revenue', data: chartData.data, borderColor: '#333', borderWidth: 3, tension: 0.4, pointBackgroundColor: '#333', pointRadius: 5 }] }, options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true } } } });
            }

            // --- Initialize all charts with pure JavaScript variables ---
            createDoughnutChart('studentGenderChart', studentGenderData);
            createDoughnutChart('coachGenderChart', coachGenderData);
            createBarChart('newUsersChart', newUsersData);
            createLineChart('revenueChart', revenueData);
        });
    </script>
</body>
</html>