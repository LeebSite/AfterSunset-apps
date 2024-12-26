<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akses Ditolak</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen font-sans">
    <div class="bg-white shadow-2xl rounded-lg p-8 max-w-md w-full mx-4">
        <div class="text-center">
            <div class="inline-block p-4 bg-red-100 rounded-full mb-6">
                <i class="fas fa-clock text-5xl text-red-500"></i>
            </div>
            <h1 class="text-3xl font-bold text-gray-800 mb-4">Akses Ditolak</h1>
            <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
                <p class="text-gray-700 text-lg">
                    Anda hanya bisa mengakses sistem ini dari pukul 
                    <span class="font-semibold text-red-600">17:00</span> hingga 
                    <span class="font-semibold text-red-600">05:00</span>.
                </p>
            </div>
            <a href="/beranda" class="inline-block px-6 py-3 bg-blue-500 text-white rounded-full hover:bg-blue-600 transition duration-300 ease-in-out transform hover:-translate-y-1 hover:shadow-lg">
                <i class="fas fa-home mr-2"></i>
                Kembali ke Halaman Utama
            </a>
        </div>
    </div>
</body>
</html>