<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TopFitness - Schedules</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/header.css') }}" rel="stylesheet">
    <link href="{{ asset('css/sidebar.css') }}" rel="stylesheet">
    <link href="{{ asset('css/stat_table.css') }}" rel="stylesheet">
    <link href="{{ asset('css/schedule_status.css') }}" rel="stylesheet">
    
</head>
<body>
    @include('layouts.header')

    <div class="container-fluid">
        <div class="row">
            @include('layouts.sidebar')

            <div class="col-md-10">
                <div class="main-content">
                    <!-- Centered Stats Card -->
                    <div class="row">
                        <div class="col-12 d-flex justify-content-center">
                            <div class="stats-card">
                                <div class="stats-icon">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                                <div class="stats-number">{{ $scheduledMeetingsCount }}</div>
                                <div class="stats-label">Scheduled Meetings</div>
                            </div>
                        </div>
                    </div>

                    <!-- Meetings Table -->
                    <div class="row">
                        <div class="col-12">
                            <div class="table-card">
                                <div class="table-header">
                                    <i class="fas fa-calendar-alt"></i>
                                    <div class="table-title">List of Meetings</div>
                                </div>
                                <div class="table-responsive">
                                    <table class="students-table">
                                        <thead>
                                            <tr>
                                                <th>Meeting ID</th>
                                                <th>Title</th>
                                                <th>Date & Time</th>
                                                <th>Meeting Link</th>
                                                <th>Status</th>
                                                <th>Coach Name</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($liveSessions as $session)
                                                <tr>
                                                    <td>{{ $session->id }}</td>
                                                    <td>{{ $session->title }}</td>
                                                    <td>{{ $session->start_time->format('M d, Y H:i A') }}</td>
                                                    <td>
                                                        <a href="{{ $session->join_url }}" target="_blank" rel="noopener noreferrer">
                                                            {{ Str::limit($session->join_url, 30) }} {{-- Display a shortened URL --}}
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <span class="status-badge status-{{ $session->status }}">
                                                            {{ $session->status }}
                                                        </span>
                                                    </td>
                                                    <td>{{ $session->coach->user->first_name ?? 'N/A' }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="text-center py-4">No live sessions found.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Global JS --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
