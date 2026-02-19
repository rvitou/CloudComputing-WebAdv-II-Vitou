<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TopFitness - Coach Details</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/header.css') }}" rel="stylesheet">
    <link href="{{ asset('css/sidebar.css') }}" rel="stylesheet">
    <link href="{{ asset('css/coach_info.css') }}" rel="stylesheet">
</head>
<body>
    @include ('layouts.header')

    <div class="container-fluid">
        <div class="row">
            @include ('layouts.sidebar')

            <div class="col-md-10">
                <div class="main-content">
                    <h1 class="page-title">Coach Information</h1>
                    
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <div class="coach-card">
                        @php
                            // Calculate the total amount due for this coach from all unpaid, expired subscriptions
                            $totalAmountDue = $coach->subscriptions
                                ->where('end_date', '<', now())
                                ->where('paid_out_to_coach', false)
                                ->sum(function ($sub) {
                                    return $sub->plan->price * 0.50;
                                });
                        @endphp

                        <div class="coach-profile">
                            <div class="coach-avatar"><i class="fas fa-user-tie"></i></div>
                            <div class="coach-info">
                                <h2 class="coach-name">{{ $coach->user->first_name }} {{ $coach->user->last_name }}</h2>
                                <p class="coach-bio">{{ $coach->bio ?? 'No bio provided.' }}</p>
                            </div>
                            <div class="amount-due-card">
                                <div class="amount-due-label">Total Amount Due</div>
                                <div class="amount-due-value">${{ number_format($totalAmountDue, 2) }}</div>
                                <div class="amount-due-currency">USD</div>
                            </div>
                        </div>
                        
                        <div class="info-grid">
                            <div class="info-item"><span class="info-label">Email:</span> <span class="info-value">{{ $coach->user->email }}</span></div>
                            <div class="info-item"><span class="info-label">Gender:</span> <span class="info-value text-capitalize">{{ $coach->user->gender }}</span></div>
                            <div class="info-item"><span class="info-label">Specialization:</span> <span class="info-value">{{ $coach->specialization }}</span></div>
                            <div class="info-item"><span class="info-label">Experience:</span> <span class="info-value">{{ $coach->years_of_experience }} years</span></div>
                            <div class="info-item"><span class="info-label">Certification:</span> <span class="info-value">{{ $coach->certification }}</span></div>
                        </div>
                        
                        <div class="students-section">
                            <h3 class="students-title">Student Subscriptions & Payouts</h3>
                            <div class="students-list">
                                @forelse ($coach->subscriptions->sortByDesc('end_date') as $sub)
                                    <div class="student-item">
                                        <div class="student-avatar"><i class="fas fa-user-graduate"></i></div>
                                        <div class="student-name">{{ $sub->student->user->first_name }} {{ $sub->student->user->last_name }}</div>
                                        
                                        @if ($sub->paid_out_to_coach)
                                            <div class="student-status status-paid">Paid Out (${{ number_format($sub->plan->price * 0.50, 2) }})</div>
                                            <button class="btn-payout disabled" disabled>Paid</button>
                                        @elseif ($sub->end_date < now())
                                            <div class="student-status status-finished">Ready for Payout (${{ number_format($sub->plan->price * 0.50, 2) }})</div>
                                            <form action="{{ route('payouts.store', $sub) }}" method="POST" onsubmit="return confirm('Process payout for this subscription?')">
                                                @csrf
                                                <button type="submit" class="btn-payout">Payout</button>
                                            </form>
                                        @else
                                            <div class="student-status status-progress">Training in Progress <br> (Ends {{ \Carbon\Carbon::parse($sub->end_date)->format('M d, Y') }})</div>
                                            <button class="btn-payout disabled" disabled>Payout</button>
                                        @endif
                                    </div>
                                @empty
                                    <p class="text-muted text-center mt-3">This coach has no student subscriptions.</p>
                                @endforelse
                            </div>
                        </div>
                        
                        <div class="action-buttons">
                            <a href="{{ route('coaches.edit', $coach) }}" class="btn-edit"><i class="fas fa-edit me-2"></i>Edit</a>
                            <form action="{{ route('coaches.destroy', $coach) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this coach? This action cannot be undone.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete"><i class="fas fa-trash me-2"></i>Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
