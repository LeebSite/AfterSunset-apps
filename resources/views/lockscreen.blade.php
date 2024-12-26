<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lock Screen</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }
        .lock-screen-template {
            padding: 40px 15px;
            text-align: center;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        .lock-icon {
            font-size: 5rem;
            color: #dc3545;
            margin-bottom: 1.5rem;
            background-color: #fde8ea;
            width: 120px;
            height: 120px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .lock-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: #343a40;
            margin-bottom: 1rem;
        }
        .lock-details {
            font-size: 1.1rem;
            color: #6c757d;
            max-width: 400px;
            margin: 0 auto 2rem;
        }
        .form-container {
            width: 100%;
            max-width: 350px;
        }
        .form-control {
            height: 50px;
            font-size: 1rem;
            border-radius: 25px;
            padding-left: 20px;
            padding-right: 20px;
        }
        .btn-unlock {
            font-size: 1.1rem;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            width: 100%;
            border-radius: 25px;
            margin-top: 1rem;
        }
        .logout-link {
            margin-top: 2rem;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <div class="lock-screen-template">
        <div class="lock-icon">
            <i class="fas fa-lock"></i>
        </div>
        <h1 class="lock-title">Lock Screen</h1>
        <p class="lock-details">Welcome back, <span class="text-primary">{{ Auth::user()->name }}</span>! Masukkan Password anda untuk kembali.</p>

        <div class="form-container">
            <form action="{{ route('lockscreen.submit') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <input
                        type="password"
                        name="password"
                        class="form-control"
                        placeholder="Your Password"
                        required
                    >
                    @error('password')
                        <p class="text-danger mt-2">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary btn-unlock">
                    Unlock
                </button>
            </form>
        </div>
        
        <div class="logout-link">
            <a href="{{ route('logout') }}" class="text-secondary">Logout</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>