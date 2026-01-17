<div class="bottom-nav">
    <a href="{{ route('dashboard') }}" class="nav-item {{ Request::routeIs('dashboard') ? 'active' : '' }}">
        <i class="fas fa-home"></i>
        <span>Beranda</span>
    </a>
    <a href="{{ route('edukasi') }}" class="nav-item {{ Request::routeIs('edukasi') ? 'active' : '' }}">
        <i class="fas fa-book-open"></i>
        <span>Artikel</span>
    </a>
    <a href="{{ route('konsultasi') }}" class="nav-item {{ Request::routeIs('konsultasi') ? 'active' : '' }}">
        <i class="fas fa-comments"></i>
        <span>Chat</span>
    </a>
    <a href="{{ route('profile') }}" class="nav-item {{ Request::routeIs('profile*') ? 'active' : '' }}">
        <i class="fas fa-user"></i>
        <span>Profil</span>
    </a>
</div>
