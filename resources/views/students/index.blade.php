<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TopFitness - Students</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/header.css') }}" rel="stylesheet">
    <link href="{{ asset('css/sidebar.css') }}" rel="stylesheet">
    <link href="{{ asset('css/stat_table.css') }}" rel="stylesheet">
</head>
<body>
    @include ('layouts.header')

    <div class="container-fluid">
        <div class="row">
            @include ('layouts.sidebar')

            <div class="col-md-10">
                <div class="main-content">
                    
                     @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="d-flex justify-content-center">
                        <div class="stats-card">
                            <div class="stats-icon"><i class="fas fa-user-graduate"></i></div>
                            <div class="stats-number">{{ $students->total() }}</div>
                            <div class="stats-label">Total Students</div>
                        </div>
                    </div>

                    <div class="table-card">
                        <div class="table-header">
                            <i class="fas fa-user-graduate"></i>
                            <div class="table-title">List of Students</div>
                        </div>
                        
                        <div class="table-responsive">
                            <table class="students-table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Age</th>
                                        <th>Current Coach</th>
                                        <th>Subscription</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($students as $student)
                                        @php
                                            // Find the latest active subscription for this student
                                            $activeSub = $student->subscriptions->where('is_active', true)->sortByDesc('start_date')->first();
                                        @endphp
                                        <tr>
                                            <td>{{ $student->id }}</td>
                                            <td>{{ $student->user->first_name ?? '' }} {{ $student->user->last_name ?? '' }}</td>
                                            <td>{{ $student->user->email ?? 'N/A' }}</td>
                                            <td>
                                                @if ($student->user->dob)
                                                    {{ \Carbon\Carbon::parse($student->user->dob)->age }}
                                                @else
                                                    <span class="text-muted">N/A</span>
                                                @endif
                                            </td>
                                            <td>
                                                <!-- Get the coach from the active subscription -->
                                                @if ($activeSub && $activeSub->coach && $activeSub->coach->user)
                                                    {{ $activeSub->coach->user->first_name }} {{ $activeSub->coach->user->last_name }}
                                                @else
                                                    <span class="text-muted">N/A</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($activeSub && $activeSub->plan)
                                                    {{ $activeSub->plan->name }}
                                                @else
                                                    <span class="text-muted">N/A</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('students.show', $student) }}" class="btn btn-sm btn-outline-info" title="View Details"><i class="fas fa-eye"></i></a>
                                                <a href="{{ route('students.edit', $student) }}" class="btn btn-sm btn-outline-primary" title="Edit Student"><i class="fas fa-edit"></i></a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center text-muted">No students found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="d-flex justify-content-center mt-4">
                            {{ $students->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
