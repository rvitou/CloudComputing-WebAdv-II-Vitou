<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exercise Details - TopFitness</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/header.css') }}" rel="stylesheet">
    <link href="{{ asset('css/sidebar.css') }}" rel="stylesheet">
    <link href="{{ asset('css/exercise_info.css') }}" rel="stylesheet">
</head>
<body>
    @include ('layouts.header')

    <div class="container-fluid">
        <div class="row">
            @include ('layouts.sidebar')
            <div class="col-md-10">
                <div class="main-content">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                         <h1 class="page-title mb-0">Exercise Details</h1>
                         <a href="{{ route('exercises.index') }}" class="btn-back">
                            <i class="fas fa-arrow-left me-2"></i>Back to List
                        </a>
                    </div>
                    
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="details-card">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="video-wrapper">
                                    @if($exercise->video_url)
                                        @php
                                            preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $exercise->video_url, $match);
                                            $youtube_id = $match[1] ?? null;
                                        @endphp
                                        @if($youtube_id)
                                            <iframe src="https://www.youtube.com/embed/{{ $youtube_id }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                        @else
                                            <div class="video-placeholder"><i class="fas fa-video-slash"></i><span>Invalid URL</span></div>
                                        @endif
                                    @else
                                        <div class="video-placeholder"><i class="fas fa-video-slash"></i><span>No Video</span></div>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-7">
                                <span class="badge bg-primary category-badge">{{ $exercise->category ?? 'General' }}</span>
                                <h2 class="exercise-title mt-2">{{ $exercise->name }}</h2>
                                
                                <div class="uploader-info mb-3">
                                    Uploaded by <strong>{{ $exercise->coach->user->first_name ?? 'N/A' }}</strong> on {{ $exercise->created_at->format('M d, Y') }}
                                </div>

                                <p class="exercise-description">
                                    {{ $exercise->description }}
                                </p>

                                <hr class="my-4">

                                <div class="action-buttons">
                                    <form action="{{ route('exercises.destroy', $exercise) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this exercise?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">
                                            <i class="fas fa-trash me-2"></i>Delete Exercise
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
