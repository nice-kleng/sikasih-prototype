<div class="bottom-nav">
    <a href="{{ route('dashboard') }}" class="nav-item {{ Request::routeIs('home') ? 'active' : '' }}">
        <i class="fas fa-home"></i>
        <span>Beranda</span>
    </a>
    <a href="{{ route('artikel') }}" class="nav-item {{ Request::routeIs('artikel') ? 'active' : '' }}">
        <i class="fas fa-newspaper"></i>
        <span>Artikel</span>
    </a>
    <a href="{{ route('konsultasi') }}" class="nav-item {{ Request::routeIs('konsultasi') ? 'active' : '' }}">
        <i class="fas fa-comments"></i>
        <span>Chat</span>
    </a>
    <a href="{{ route('profile') }}" class="nav-item {{ Request::routeIs('profil*') ? 'active' : '' }}">
        <i class="fas fa-user"></i>
        <span>Profil</span>
    </a>
</div>
