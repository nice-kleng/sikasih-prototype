@extends('layouts.app')

@section('title', 'Beranda - SIKASIH')

@section('content')
<div class="header">
    <h1>SIKASIH</h1>
    <p>Sistem Informasi Integrasi Komunitas Asuhan Ibu Hamil</p>
</div>

@push('styles')
<style>
    .slider-container {
        position: relative;
        overflow: hidden;
        height: 220px;
        background: white;
    }

    .slider {
        display: flex;
        transition: transform 0.5s ease;
        height: 100%;
    }

    .slide {
        min-width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #ffe0ef 0%, #ffeef8 100%);
        position: relative;
    }

    .slide-content {
        text-align: center;
        padding: 30px;
        z-index: 2;
    }

    .slide-content i {
        font-size: 60px;
        color: #ff6b9d;
        margin-bottom: 15px;
    }

    .slide-content h3 {
        color: #ff6b9d;
        font-size: 20px;
        margin-bottom: 10px;
        font-weight: 700;
    }

    .slide-content p {
        color: #666;
        font-size: 14px;
    }

    .slider-dots {
        position: absolute;
        bottom: 15px;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        gap: 8px;
        z-index: 3;
    }

    .dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: rgba(255, 107, 157, 0.3);
        cursor: pointer;
        transition: all 0.3s;
    }

    .dot.active {
        background: #ff6b9d;
        width: 24px;
        border-radius: 4px;
    }

    .menu-container {
        padding: 20px;
        background: white;
        margin-top: -10px;
        border-radius: 20px 20px 0 0;
        box-shadow: 0 -3px 10px rgba(0, 0, 0, 0.05);
    }

    .menu-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
        margin-bottom: 20px;
    }

    .menu-item {
        background: linear-gradient(135deg, #fff0f6 0%, #ffe8f2 100%);
        border: 2px solid #ffcce0;
        border-radius: 15px;
        padding: 25px 15px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s;
        text-decoration: none;
        display: block;
    }

    .menu-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(255, 107, 157, 0.2);
        border-color: #ff6b9d;
    }

    .menu-item i {
        font-size: 40px;
        color: #ff6b9d;
        margin-bottom: 12px;
        display: block;
    }

    .menu-item span {
        color: #333;
        font-size: 13px;
        font-weight: 600;
        display: block;
    }

    .article-card {
        background: white;
        border-radius: 12px;
        padding: 15px;
        margin-bottom: 15px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        display: flex;
        gap: 15px;
        cursor: pointer;
        transition: all 0.3s;
        text-decoration: none;
        color: inherit;
    }

    .article-card:hover {
        box-shadow: 0 4px 15px rgba(255, 107, 157, 0.2);
        transform: translateY(-2px);
    }

    .article-img {
        width: 80px;
        height: 80px;
        border-radius: 10px;
        object-fit: cover;
        background: linear-gradient(135deg, #ffe0ef 0%, #ffeef8 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .article-img i {
        font-size: 30px;
        color: #ff6b9d;
    }

    .article-content h4 {
        font-size: 14px;
        font-weight: 600;
        color: #333;
        margin-bottom: 5px;
        line-height: 1.4;
    }

    .article-content p {
        font-size: 12px;
        color: #666;
        margin: 0;
        line-height: 1.5;
    }

    .read-more {
        color: #ff6b9d;
        font-size: 11px;
        font-weight: 600;
        margin-top: 5px;
        display: inline-block;
    }

    .login-btn {
        background: linear-gradient(135deg, #ff6b9d 0%, #ff8fab 100%);
        color: white;
        border: none;
        width: 100%;
        padding: 15px;
        border-radius: 12px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        margin-top: 10px;
    }

    .login-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(255, 107, 157, 0.3);
    }
</style>
@endpush

<div class="slider-container">
    <div class="slider" id="slider">
        <div class="slide">
            <div class="slide-content">
                <img src="{{ asset('images/bidan-online.jpg') }}" alt="Ibu Hamil" width="400" height="250">
            </div>
        </div>
        <div class="slide">
            <div class="slide-content">
                <i class="fas fa-user-nurse"></i>
                <h3>Konsultasi dengan Bidan</h3>
                <p>Tanya jawab langsung dengan bidan profesional</p>
            </div>
        </div>
        <div class="slide">
            <div class="slide-content">
                <i class="fas fa-book-medical"></i>
                <h3>Edukasi Kehamilan</h3>
                <p>Pelajari tips dan informasi penting seputar kehamilan</p>
            </div>
        </div>
    </div>
    <div class="slider-dots">
        <div class="dot active" onclick="goToSlide(0)"></div>
        <div class="dot" onclick="goToSlide(1)"></div>
        <div class="dot" onclick="goToSlide(2)"></div>
    </div>
</div>

<div class="content">
    <div class="menu-container">

        @guest
        <button class="login-btn" onclick="window.location.href='{{ route('register') }}'">
            <i class="fas fa-sign-in-alt"></i> Login / Daftar
        </button>
        @endguest

        <h2 class="section-title">Menu Utama</h2>
        <div class="menu-grid">
            <a href="{{ route('deteksi-risiko') }}" class="menu-item">
                <i class="fas fa-file-medical"></i>
                <span>Deteksi Resiko<br>Kehamilan</span>
            </a>
            <a href="{{ route('konsultasi') }}" class="menu-item">
                <i class="fas fa-user-nurse"></i>
                <span>Konsultasi<br>Bidan</span>
            </a>
            <a href="{{ route('video') }}" class="menu-item">
                <i class="fas fa-video"></i>
                <span>Video<br>Edukasi</span>
            </a>
            <a href="{{ route('perawatan') }}" class="menu-item">
                <i class="fas fa-hand-holding-heart"></i>
                <span>Perawatan<br>Ibu Hamil</span>
            </a>
        </div>

        <h2 class="section-title">Artikel Kesehatan</h2>

        @foreach ($artikels as $artikel)
        <a href="{{ route('artikel.detail', $artikel['id']) }}" class="article-card">
            <div class="article-img">
                <i class="{{ $artikel['icon'] }}"></i>
            </div>
            <div class="article-content">
                <h4>{{ $artikel['judul'] }}</h4>
                <p>{{ $artikel['excerpt'] }}</p>
                <span class="read-more">Baca Selengkapnya →</span>
            </div>
        </a>
        @endforeach
    </div>
</div>

@push('scripts')
<script>
    let currentSlide = 0;
    const slider = document.getElementById('slider');
    const dots = document.querySelectorAll('.dot');
    const totalSlides = 3;

    function goToSlide(index) {
        currentSlide = index;
        slider.style.transform = `translateX(-${currentSlide * 100}%)`;
        updateDots();
    }

    function updateDots() {
        dots.forEach((dot, index) => {
            dot.classList.toggle('active', index === currentSlide);
        });
    }

    function nextSlide() {
        currentSlide = (currentSlide + 1) % totalSlides;
        goToSlide(currentSlide);
    }

    setInterval(nextSlide, 4000);

    let touchStartX = 0;
    let touchEndX = 0;

    slider.addEventListener('touchstart', (e) => {
        touchStartX = e.changedTouches[0].screenX;
    });

    slider.addEventListener('touchend', (e) => {
        touchEndX = e.changedTouches[0].screenX;
        handleSwipe();
    });

    function handleSwipe() {
        if (touchStartX - touchEndX > 50) {
            currentSlide = (currentSlide + 1) % totalSlides;
            goToSlide(currentSlide);
        }
        if (touchEndX - touchStartX > 50) {
            currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
            goToSlide(currentSlide);
        }
    }
</script>
@endpush
@endsection
