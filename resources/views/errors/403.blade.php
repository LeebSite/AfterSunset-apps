<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Akses Ditolak</title>

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
        .error-template {
            padding: 40px 15px;
            text-align: center;
        }
        .error-actions {
            margin-top: 25px;
            margin-bottom: 15px;
        }
        .error-icon {
            font-size: 8rem;
            color: #dc3545;
            margin-bottom: 2rem;
        }
        .error-code {
            font-size: 6rem;
            font-weight: 800;
            color: #343a40;
            margin-bottom: 1rem;
        }
        .error-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: #343a40;
            margin-bottom: 1.5rem;
        }
        .error-details {
            font-size: 1.2rem;
            color: #6c757d;
            max-width: 500px;
            margin: 0 auto 2rem;
        }
        .btn-back-home {
            font-size: 1.1rem;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="error-template min-vh-100 d-flex flex-column justify-content-center">
                    <div class="error-icon">
                        <i class="fas fa-lock"></i>
                    </div>
                    <h1 class="error-code"> 403</h1>
                    <h2 class="error-title">Akses Ditolak</h2>
                    <div class="error-details">
                        {{ $message }}
                    </div>
                    <div class="error-actions">
                        <a href="/beranda" class="btn btn-primary btn-lg btn-back-home">
                            <i class="fas fa-home me-2"></i>
                            Kembali ke Beranda
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>