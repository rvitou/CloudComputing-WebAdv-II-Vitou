<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Coach - TopFitness</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/header.css') }}" rel="stylesheet">
    <link href="{{ asset('css/sidebar.css') }}" rel="stylesheet">
    <link href="{{ asset('css/edit_form.css') }}" rel="stylesheet">
</head>
<body>
    @include('layouts.header')

    <div class="container-fluid">
        <div class="row">
            @include('layouts.sidebar')

            <div class="col-md-10">
                <div class="main-content">
                    <h1 class="page-title">Edit Coach Information</h1>
                    
                    <div class="form-container">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('coaches.update', $coach) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="first_name" class="form-label">First Name: <span class="required">*</span></label>
                                    <input type="text" class="form-control" id="first_name" name="first_name" value="{{ old('first_name', $coach->user->first_name) }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="last_name" class="form-label">Last Name: <span class="required">*</span></label>
                                    <input type="text" class="form-control" id="last_name" name="last_name" value="{{ old('last_name', $coach->user->last_name) }}" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="email" class="form-label">Email: <span class="required">*</span></label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $coach->user->email) }}" required>
                            </div>

                            <div class="form-group">
                                <label for="specialization" class="form-label">Specialization: <span class="required">*</span></label>
                                <input type="text" class="form-control" id="specialization" name="specialization" value="{{ old('specialization', $coach->specialization) }}" required>
                            </div>

                            <div class="form-group">
                                <label for="years_of_experience" class="form-label">Years of Experience: <span class="required">*</span></label>
                                <input type="number" class="form-control" id="years_of_experience" name="years_of_experience" value="{{ old('years_of_experience', $coach->years_of_experience) }}" required min="0">
                            </div>

                            <div class="form-group">
                                <label for="certification" class="form-label">Certification: <span class="required">*</span></label>
                                <input type="text" class="form-control" id="certification" name="certification" value="{{ old('certification', $coach->certification) }}" required>
                            </div>

                            <div class="form-group">
                                <label for="bio" class="form-label">Bio:</label>
                                <textarea class="form-control" id="bio" name="bio" rows="4">{{ old('bio', $coach->bio) }}</textarea>
                            </div>

                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-update">
                                    <i class="fas fa-save me-2"></i>Update Coach
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
