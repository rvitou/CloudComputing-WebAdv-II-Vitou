<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Admin Login | Top Fitness</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <style>
        html, body {
            height: 100%;
            margin: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        }

        .main-container {
            height: 100vh;
            display: flex;
        }

        .left-panel {
            width: 40%;
            /* === COLOR CHANGE HERE === */
            background: linear-gradient(45deg, #ff6b6b, #ff8e8e); /* Using your color and a lighter shade for a soft look */
            color: white;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 40px;
            text-align: center;
        }

        .left-panel img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            margin-bottom: 20px;
            border: 3px solid rgba(255, 255, 255, 0.5);
        }

        .left-panel h1 {
            font-size: 2.5rem;
            font-weight: 600;
        }
        
        .left-panel p {
            font-size: 1.1rem;
            opacity: 0.9;
            margin-top: 10px;
        }

        .right-panel {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f8f9fa;
            padding: 40px;
        }

        .login-form-container {
            width: 100%;
            max-width: 400px;
            background-color: #ffffff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .login-form-container h3 {
            color: #333;
            margin-bottom: 25px;
            font-size: 24px;
            font-weight: 600;
            text-align: center;
        }

        .form-control {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 12px 15px;
            font-size: 16px;
            height: 50px;
        }
        
        .form-control:focus {
             /* === COLOR CHANGE HERE === */
            border-color: #ff6b6b;
            box-shadow: 0 0 0 0.25rem rgba(255, 107, 107, 0.25); /* Glow effect for your color */
        }

        .btn-login {
             /* === COLOR CHANGE HERE === */
            background-color: #ff6b6b;
            color: #ffffff;
            border: none;
            border-radius: 8px;
            padding: 12px;
            font-weight: bold;
            font-size: 16px;
            width: 100%;
            transition: background-color 0.3s ease;
        }

        .btn-login:hover {
             /* === COLOR CHANGE HERE === */
            background-color: #e65c5c; /* A slightly darker shade for hover effect */
        }

        @media (max-width: 768px) {
            .main-container {
                flex-direction: column;
            }

            .left-panel {
                width: 100%;
                height: auto;
                padding: 30px 20px;
            }

            .right-panel {
                flex-grow: 1;
                align-items: flex-start;
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="main-container">
        <!-- Left panel -->
        <div class="left-panel">
            <img src="{{ asset('img/TFlogo.jpg') }}" alt="TF Logo" />
            <div>
                <h1>Top Fitness</h1>
                <p>Administration Panel</p>
            </div>
        </div>

        <!-- Right panel -->
        <div class="right-panel">
            <div class="login-form-container">
                <h3>Admin Login</h3>

                @if ($errors->any())
                    <div class="alert alert-danger" role="alert">
                        {{ $errors->first('email') }}
                    </div>
                @endif
                
                <form method="POST" action="{{ route('login.post') }}">
                    @csrf
                    
                    <div class="mb-3">
                        <input type="email" class="form-control" name="email" placeholder="Enter Email" value="{{ old('email') }}" required autofocus />
                    </div>
                    <div class="mb-3">
                        <input type="password" class="form-control" name="password" placeholder="Enter Password" required />
                    </div>
                    
                    <div class="mb-3 form-check">
                      <input type="checkbox" class="form-check-input" name="remember" id="remember">
                      <label class="form-check-label" for="remember">Remember Me</label>
                    </div>

                    <button type="submit" class="btn-login">Login</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
