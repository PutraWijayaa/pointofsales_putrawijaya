<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Akses Ditolak</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <style>
        body {
            font-family: 'Figtree', sans-serif;
            background-color: #f3f4f6;
            color: #1f2937;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
        }

        .container {
            max-width: 500px;
            padding: 2rem;
            background-color: white;
            border-radius: 0.5rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .error-code {
            font-size: 5rem;
            font-weight: 700;
            color: #ef4444;
            margin-bottom: 1rem;
        }

        .title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .description {
            color: #6b7280;
            margin-bottom: 2rem;
        }

        .btn {
            display: inline-block;
            background-color: #2563eb;
            color: white;
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 0.25rem;
            text-decoration: none;
            transition: background-color 0.2s;
        }

        .btn:hover {
            background-color: #1d4ed8;
        }

        .icon {
            font-size: 4rem;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- <div class="icon">🔒</div> -->
        <div class="icon">
            <img src="{{ asset('assets/img/404.png') }}" alt="" width="200">
        </div>
        <div class="error-code">403</div>
        <h1 class="title">Akses Ditolak</h1>
        <p class="description">
            Maaf, Anda tidak memiliki izin untuk mengakses halaman ini.
            Silakan hubungi administrator jika Anda yakin seharusnya memiliki akses.
        </p>
        <a href="{{ url('/') }}" class="btn">Kembali ke Beranda</a>
    </div>
</body>
</html>
