<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TopFitness - Student Details</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/header.css') }}" rel="stylesheet">
    <link href="{{ asset('css/sidebar.css') }}" rel="stylesheet">
    <link href="{{ asset('css/stu_info.css') }}" rel="stylesheet">
</head>
<body>
    @include ('layouts.header')

    <div class="container-fluid">
        <div class="row">
            @include ('layouts.sidebar')

            <!-- Main Content -->
            <div class="col-md-10">
                <div class="main-content">
                    <h1 class="page-title">Student Information</h1>
                    
                    <!-- Display success messages from the controller -->
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="student-card">
                        <div class="student-header">
                            <div class="profile-image">
                                <i class="fas fa-user-graduate"></i>
                            </div>
                            <!-- Use the student's name from the database -->
                            <h2 class="student-name">{{ $student->user->first_name }} {{ $student->user->last_name }}</h2>
                        </div>
                        
                        <!-- 
                            ==================================================================
                            DYNAMIC DETAILS:
                            The hardcoded JavaScript is gone. We now use Blade to directly
                            print the student's details from the controller.
                            ==================================================================
                        -->
                        <div class="student-details">
                            <div class="detail-row">
                                <span class="detail-label">Email:</span>
                                <span class="detail-value">{{ $student->user->email ?? 'N/A' }}</span>
                            </div>
                             <div class="detail-row">
                                <span class="detail-label">D.O.B:</span>
                                <!-- Format the date for readability -->
                                <span class="detail-value">{{ $student->user->dob ? \Carbon\Carbon::parse($student->user->dob)->format('F j, Y') : 'N/A' }}</span>
                            </div>
                             <div class="detail-row">
                                <span class="detail-label">Gender:</span>
                                <span class="detail-value text-capitalize">{{ $student->user->gender ?? 'N/A' }}</span>
                            </div>
                             <div class="detail-row">
                                <span class="detail-label">Height:</span>
                                <span class="detail-value">{{ $student->height ? $student->height . 'cm' : 'N/A' }}</span>
                            </div>
                             <div class="detail-row">
                                <span class="detail-label">Weight:</span>
                                <span class="detail-value">{{ $student->weight ? $student->weight . 'kg' : 'N/A' }}</span>
                            </div>
                             <div class="detail-row">
                                <span class="detail-label">Fitness Experience:</span>
                                <span class="detail-value">{{ $student->experience_level ?? 'N/A' }}</span>
                            </div>
                             <div class="detail-row">
                                <span class="detail-label">Fitness Goal:</span>
                                <span class="detail-value">{{ $student->fitness_goal ?? 'N/A' }}</span>
                            </div>
                            <hr>
                            <div class="detail-row">
                                <span class="detail-label">Assigned Coach:</span>
                                <span class="detail-value">
                                    @if ($student->coach && $student->coach->user)
                                        {{ $student->coach->user->first_name }} {{ $student->coach->user->last_name }}
                                    @else
                                        N/A
                                    @endif
                                </span>
                            </div>
                            @php
                                $latestSub = $student->subscriptions->where('is_active', true)->sortByDesc('created_at')->first();
                            @endphp
                             <div class="detail-row">
                                <span class="detail-label">Subscription Plan:</span>
                                <span class="detail-value">
                                    @if ($latestSub && $latestSub->plan)
                                        {{ $latestSub->plan->name }} ({{ $latestSub->plan->duration_days }} days)
                                    @else
                                        N/A
                                    @endif
                                </span>
                            </div>
                             <div class="detail-row">
                                <span class="detail-label">Plan Active Until:</span>
                                <span class="detail-value">
                                    @if ($latestSub)
                                        {{ \Carbon\Carbon::parse($latestSub->end_date)->format('F j, Y') }}
                                    @else
                                        N/A
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- 
                        ==================================================================
                        DYNAMIC ACTION BUTTONS:
                        These buttons now point to the correct routes for this specific student.
                        The Delete button is a secure form.
                        ==================================================================
                    -->
                    <div class="action-buttons">
                        <a href="{{ route('students.edit', $student) }}" class="btn-edit">
                            <i class="fas fa-edit me-2"></i>Edit
                        </a>

                        <!-- The delete button is now a form for security -->
                        <form action="{{ route('students.destroy', $student) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this student? This action cannot be undone.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete">
                                <i class="fas fa-trash me-2"></i>Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- We no longer need the hardcoded JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
