<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TopFitness - Coaches</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/header.css') }}" rel="stylesheet">
    <link href="{{ asset('css/sidebar.css') }}" rel="stylesheet">
    <link href="{{ asset('css/stat_table.css') }}" rel="stylesheet">
</head>
<body>
    @include('layouts.header')

    <div class="container-fluid">
        <div class="row">
            @include('layouts.sidebar')

            <div class="col-md-10">
                <div class="main-content">

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <div class="d-flex justify-content-center">
                        <div class="stats-card">
                            <div class="stats-icon"><i class="fas fa-user-tie"></i></div>
                            <div class="stats-number">{{ $coaches->total() }}</div>
                            <div class="stats-label">Total Coaches</div>
                        </div>
                    </div>

                    <div class="table-card">
                        <div class="table-header">
                            <i class="fas fa-users"></i>
                            <div class="table-title">List of Coaches</div>
                        </div>
                        <div class="table-responsive">
                            <table class="students-table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Active Students</th>
                                        <th>Payout Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($coaches as $coach)
                                        @php
                                            // Calculate amount due and active students from the coach's subscriptions
                                            $amountDue = 0;
                                            $activeStudentIds = [];
                                            foreach ($coach->subscriptions as $sub) {
                                                if ($sub->end_date < now() && !$sub->paid_out_to_coach) {
                                                    $amountDue += $sub->plan->price * 0.50;
                                                }
                                                if ($sub->is_active) {
                                                    $activeStudentIds[] = $sub->student_id;
                                                }
                                            }
                                            // Count only the unique active students
                                            $activeStudentCount = count(array_unique($activeStudentIds));
                                        @endphp
                                        <tr>
                                            <td>{{ $coach->id }}</td>
                                            <td>{{ $coach->user->first_name ?? '' }} {{ $coach->user->last_name ?? '' }}</td>
                                            <td>{{ $coach->user->email ?? 'N/A' }}</td>
                                            <td>
                                                @if ($activeStudentCount > 0)
                                                    <span class="student-count">{{ $activeStudentCount }}</span>
                                                @else
                                                    <span class="text-muted">N/A</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($amountDue > 0)
                                                    <span class="status-badge status-due">Due</span>
                                                @else
                                                    <span class="status-badge status-paid">Paid</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('coaches.show', $coach) }}" class="btn btn-sm btn-outline-info" title="View Details"><i class="fas fa-eye"></i></a>
                                                <a href="{{ route('coaches.edit', $coach) }}" class="btn btn-sm btn-outline-primary" title="Edit Coach"><i class="fas fa-edit"></i></a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted">No coaches found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center mt-4">
                            {{ $coaches->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
