<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Akses Ditolak</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <style>
    :root {
        --primary: #ff3d3d;
        --primary-dark: #d63030;
        --dark: #1a1a1a;
        --light: #f8f9fa;
    }

    body {
        font-family: 'Figtree', sans-serif;
        background-color: var(--dark);
        color: var(--light);
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
        margin: 0;
        overflow-x: hidden;
        background-image:
            radial-gradient(circle at 10% 20%, rgba(255, 61, 61, 0.1) 0%, transparent 20%),
            radial-gradient(circle at 90% 80%, rgba(255, 61, 61, 0.1) 0%, transparent 20%);
    }

    .container {
        max-width: 500px;
        padding: 2.5rem;
        background-color: rgba(26, 26, 26, 0.9);
        border-radius: 1rem;
        box-shadow: 0 10px 30px rgba(255, 61, 61, 0.2);
        text-align: center;
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(255, 61, 61, 0.3);
        backdrop-filter: blur(5px);
        transform-style: preserve-3d;
        transition: all 0.5s ease;
    }

    .container:hover {
        transform: translateY(-5px) rotateX(2deg);
        box-shadow: 0 15px 35px rgba(255, 61, 61, 0.3);
    }

    .container::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: linear-gradient(
            to bottom right,
            transparent 45%,
            rgba(255, 61, 61, 0.1) 50%,
            transparent 55%
        );
        transform: rotate(30deg);
        animation: shine 3s infinite;
    }

    @keyframes shine {
        0% { transform: translateX(-100%) rotate(30deg); }
        100% { transform: translateX(100%) rotate(30deg); }
    }

    .error-code {
        font-size: 6rem;
        font-weight: 700;
        color: var(--primary);
        margin-bottom: 1rem;
        text-shadow: 0 0 10px rgba(255, 61, 61, 0.5);
        position: relative;
        display: inline-block;
    }

    .error-code::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 0;
        width: 100%;
        height: 4px;
        background: var(--primary);
        border-radius: 2px;
        transform: scaleX(0);
        transform-origin: right;
        animation: lineGrow 1s 0.5s forwards cubic-bezier(0.65, 0, 0.35, 1);
    }

    @keyframes lineGrow {
        0% { transform: scaleX(0); }
        100% { transform: scaleX(1); }
    }

    .title {
        font-size: 1.75rem;
        font-weight: 600;
        margin-bottom: 1rem;
        color: var(--light);
    }

    .description {
        color: #a1a1a1;
        margin-bottom: 2rem;
        line-height: 1.6;
    }

    .btn {
        display: inline-block;
        background-color: var(--primary);
        color: white;
        font-weight: 600;
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
        text-decoration: none;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        border: none;
        cursor: pointer;
        box-shadow: 0 4px 15px rgba(255, 61, 61, 0.3);
    }

    .btn:hover {
        background-color: var(--primary-dark);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(255, 61, 61, 0.4);
    }

    .btn:active {
        transform: translateY(0);
    }

    .btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(
            90deg,
            transparent,
            rgba(255, 255, 255, 0.2),
            transparent
        );
        transition: 0.5s;
    }

    .btn:hover::before {
        left: 100%;
    }

    .icon {
        margin-bottom: 1.5rem;
        filter: drop-shadow(0 0 10px rgba(255, 61, 61, 0.5));
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }

    .forbidden-sign {
        position: absolute;
        width: 150px;
        height: 150px;
        border: 8px solid var(--primary);
        border-radius: 50%;
        opacity: 0.1;
        animation: rotate 20s linear infinite;
    }

    .forbidden-sign:nth-child(1) {
        top: -75px;
        left: -75px;
    }

    .forbidden-sign:nth-child(2) {
        bottom: -75px;
        right: -75px;
    }

    @keyframes rotate {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .particles {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: -1;
    }

    .particle {
        position: absolute;
        background-color: var(--primary);
        border-radius: 50%;
        opacity: 0;
        animation: float 5s infinite ease-in-out;
    }

    @keyframes float {
        0% {
            transform: translateY(0) rotate(0deg);
            opacity: 0;
        }
        10% {
            opacity: 0.3;
        }
        100% {
            transform: translateY(-100vh) rotate(360deg);
            opacity: 0;
        }
    }

    .glow {
        position: absolute;
        width: 100px;
        height: 100px;
        background: radial-gradient(circle, rgba(255,61,61,0.5) 0%, rgba(255,61,61,0) 70%);
        border-radius: 50%;
        filter: blur(10px);
        animation: glowPulse 3s infinite alternate;
    }

    @keyframes glowPulse {
        0% { transform: scale(0.8); opacity: 0.5; }
        100% { transform: scale(1.2); opacity: 0.8; }
    }
    </style>
</head>

<body>
    <div class="container animate__animated animate__fadeIn">
        <div class="forbidden-sign"></div>
        <div class="forbidden-sign"></div>

        <div class="glow" style="top: 20%; left: 10%;"></div>
        <div class="glow" style="bottom: 20%; right: 10%;"></div>

        <div class="icon animate__animated animate__bounceIn">
            <img src="{{ asset('assets/img/404.png') }}" alt="Forbidden" width="120">
        </div>
        <div class="error-code animate__animated animate__fadeIn">403</div>
        <h1 class="title animate__animated animate__fadeIn animate__delay-1s">Akses Ditolak</h1>
        <p class="description animate__animated animate__fadeIn animate__delay-1s">
            Maaf, Anda tidak memiliki izin untuk mengakses halaman ini.
            <br>
            Silakan hubungi administrator jika Anda yakin seharusnya memiliki akses.
        </p>
        <a href="{{ url('/') }}" class="btn animate__animated animate__fadeInUp animate__delay-2s">Kembali ke Beranda</a>
    </div>

    <div class="particles" id="particles"></div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Create particles
            const particlesContainer = document.getElementById('particles');
            const particleCount = 20;

            for (let i = 0; i < particleCount; i++) {
                const particle = document.createElement('div');
                particle.classList.add('particle');

                // Random properties
                const size = Math.random() * 6 + 2;
                const posX = Math.random() * 100;
                const delay = Math.random() * 5;
                const duration = Math.random() * 3 + 3;

                particle.style.width = `${size}px`;
                particle.style.height = `${size}px`;
                particle.style.left = `${posX}%`;
                particle.style.bottom = `-${size}px`;
                particle.style.animationDelay = `${delay}s`;
                particle.style.animationDuration = `${duration}s`;
                particle.style.opacity = Math.random() * 0.5 + 0.1;

                particlesContainer.appendChild(particle);
            }

            // Add hover effect to container
            const container = document.querySelector('.container');
            container.addEventListener('mousemove', (e) => {
                const x = e.clientX / window.innerWidth;
                const y = e.clientY / window.innerHeight;

                container.style.transform = `rotateY(${(x - 0.5) * 5}deg) rotateX(${(y - 0.5) * -5}deg)`;
            });

            container.addEventListener('mouseleave', () => {
                container.style.transform = '';
            });
        });
    </script>
</body>

</html>
