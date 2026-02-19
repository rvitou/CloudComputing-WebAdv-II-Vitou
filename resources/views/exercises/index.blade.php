<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TopFitness - Exercises</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/header.css') }}" rel="stylesheet">
    <link href="{{ asset('css/sidebar.css') }}" rel="stylesheet">
    <link href="{{ asset('css/exercises.css') }}" rel="stylesheet">
</head>
<body>
    @include ('layouts.header')

    <div class="container-fluid">
        <div class="row">
            @include ('layouts.sidebar')
            <div class="col-md-10">
                <div class="main-content">
                    
                    @if (session('success'))
                        <div class="alert alert-success mt-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="row justify-content-center">
                        <div class="col-md-4">
                             <div class="stats-card">
                                <div class="stats-icon">
                                    <i class="fas fa-dumbbell"></i>
                                </div>
                                <div class="stats-number">{{ $exercises->total() }}</div>
                                <div class="stats-label">Total Exercises</div>
                            </div>
                        </div>
                    </div>
            
                    <!-- Exercise Grid -->
                    <div class="row exercise-grid mt-4">
                        @forelse ($exercises as $exercise)
                            <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                                <div class="exercise-card">
                                    <div class="placeholder-image">
                                        <i class="fas fa-dumbbell"></i>
                                    </div>
                                    <div class="exercise-info">
                                        <div class="exercise-category">{{ $exercise->category ?? 'General' }}</div>
                                        <div class="exercise-name">{{ $exercise->name }}</div>
                                        <div class="exercise-coach">
                                            Uploaded by: {{ $exercise->coach->user->first_name ?? 'N/A' }}
                                        </div>
                                    </div>
                                    <div class="exercise-actions">
                                        <a href="{{ route('exercises.show', $exercise) }}" class="action-btn btn-view" title="View Details"><i class="fas fa-eye"></i></a>
                                        <form action="{{ route('exercises.destroy', $exercise) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this exercise?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="action-btn btn-delete" title="Delete Exercise"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <p class="text-center text-muted mt-5">No exercises have been created yet.</p>
                            </div>
                        @endforelse
                    </div>
                    
                    <!-- Pagination Links -->
                    <div class="d-flex justify-content-center mt-4">
                        {{ $exercises->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
