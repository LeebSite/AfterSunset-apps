<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Pengelolaan Data Kasir</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(55deg, #002366, #0214b7); /* Gradient background */
            font-family: 'Poppins', sans-serif;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            overflow: hidden;
        }
        h2 {
            font-size: 30px
        }
        .background-logo {
            position: absolute;
            bottom: -200px; /* Adjust to position correctly */
            left: -190px; /* Adjust to position correctly */
            width: 900px; /* Adjust size as needed */
            opacity: 0.2; /* Half transparent */
            transform: rotate(30deg); /* Diagonal position */
            z-index: 1;
        }
        .login-container {
            background-color: rgba(255, 255, 255, 0.6); /* Slight transparency */
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            padding: 3rem;
            max-width: 500px;
            width: 100%;
            text-align: center;
            position: relative;
            z-index: 2; /* Ensure container is above the background logo */
        }
        .login-logo {
            max-width: 100px;
            margin-bottom: 1rem;
        }
        .form-control {
            background-color: rgba(255, 255, 255, 0.7);
            border-radius: 12px;
            border: 1px solid #ccc;
            padding: 0.75rem;
        }
        .btn-primary {
            background-color: #004aad;
            border: none;
            border-radius: 10px;
            padding: 0.75rem;
        }
        .btn-primary:hover {
            background-color: #00308f;
        }
        .password-container {
            position: relative;
        }
        .password-toggle {
            position: absolute;
            top: 50%;
            right: 15px;
            transform: translateY(-50%);
            cursor: pointer;
        }
    </style>
</head>
<body>
    <!-- Background Logo -->
    <img src="{{ asset('images/logo-aftersunset.png') }}" alt="Background Logo" class="background-logo">

    <div class="login-container">
        <img src="{{ asset('images/logo-aftersunset.png') }}" alt="After Sunset Logo" class="login-logo">
        <h2 class="mb-4">Selamat Datang di <br> Sistem Kasir AfterSunset</h2>

        <!-- Error message -->
        @if (Session::has('status'))
            <div class="alert alert-danger">{{ Session::get('message') }}</div>
        @endif

        <!-- Login form -->
        <form action="{{ route('login') }}" method="post">
            @csrf
            <div class="mb-4">
                <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
            </div>
            <div class="mb-5 password-container">
                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                <i class="bi bi-eye-slash password-toggle" id="togglePassword"></i>
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
    </div>

    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');

        togglePassword.addEventListener('click', function () {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.classList.toggle('bi-eye');
            this.classList.toggle('bi-eye-slash');
        });
    </script>
</body>
</html>
