<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student - TopFitness</title>
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
                    <div class="container-fluid">
                        <h1 class="page-title">Edit Student Information</h1>
                        <div class="form-container">
                            
                            <!-- Display Validation Errors if any -->
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            
                            <!-- 
                                ==================================================================
                                DYNAMIC FORM:
                                - The 'action' points to the update route for this specific student.
                                - We use @method('PUT') because HTML forms don't support PUT directly.
                                - The 'value' of each input is pre-filled with the student's data.
                                  old('field', $student->...) ensures that if validation fails,
                                  the user's entered data is shown instead of the old data.
                                ==================================================================
                            -->
                            <form action="{{ route('students.update', $student) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="firstName" class="form-label">First Name: <span class="required">*</span></label>
                                        <input type="text" class="form-control" id="firstName" name="first_name" value="{{ old('first_name', $student->user->first_name) }}" required>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="lastName" class="form-label">Last Name: <span class="required">*</span></label>
                                        <input type="text" class="form-control" id="lastName" name="last_name" value="{{ old('last_name', $student->user->last_name) }}" required>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="gender" class="form-label">Gender:</label>
                                    <select class="form-control" id="gender" name="gender">
                                        <option value="male" {{ old('gender', $student->user->gender) == 'male' ? 'selected' : '' }}>Male</option>
                                        <option value="female" {{ old('gender', $student->user->gender) == 'female' ? 'selected' : '' }}>Female</option>
                                        <option value="other" {{ old('gender', $student->user->gender) == 'other' ? 'selected' : '' }}>Other</option>
                                        <option value="prefer_not_to_say" {{ old('gender', $student->user->gender) == 'prefer_not_to_say' ? 'selected' : '' }}>Prefer not to say</option>
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label for="dob" class="form-label">D.O.B:</label>
                                    <input type="date" class="form-control" id="dob" name="dob" value="{{ old('dob', $student->user->dob) }}">
                                </div>
                                
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="height" class="form-label">Height (cm):</label>
                                        <input type="number" class="form-control" id="height" name="height" value="{{ old('height', $student->height) }}" step="0.1">
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="weight" class="form-label">Weight (kg):</label>
                                        <input type="number" class="form-control" id="weight" name="weight" value="{{ old('weight', $student->weight) }}" step="0.1">
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="experience_level" class="form-label">Fitness Experience:</label>
                                    <select class="form-control" id="experience_level" name="experience_level">
                                        <option value="Beginner" {{ old('experience_level', $student->experience_level) == 'Beginner' ? 'selected' : '' }}>Beginner</option>
                                        <option value="Intermediate" {{ old('experience_level', $student->experience_level) == 'Intermediate' ? 'selected' : '' }}>Intermediate</option>
                                        <option value="Advanced" {{ old('experience_level', $student->experience_level) == 'Advanced' ? 'selected' : '' }}>Advanced</option>
                                        <option value="Expert" {{ old('experience_level', $student->experience_level) == 'Expert' ? 'selected' : '' }}>Expert</option>
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label for="fitness_goal" class="form-label">Fitness Goal:</label>
                                    <input type="text" class="form-control" id="fitness_goal" name="fitness_goal" value="{{ old('fitness_goal', $student->fitness_goal) }}">
                                </div>
                                
                                <div class="text-center mt-4">
                                    <button type="submit" class="btn btn-update">
                                        <i class="fas fa-save me-2"></i>Update Student
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- We no longer need the JavaScript that handles form submission --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

</body>
</html>