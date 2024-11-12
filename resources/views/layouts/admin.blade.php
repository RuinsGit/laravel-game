<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Paneli</title>
   @include('layouts.head')
</head>
<body>
<!-- Üst Header -->
<header class="admin-header">
    <div class="logo-container">
        <a href="{{ route('admin.dashboard') }}" class="logo-link">
            <img src="{{ asset('images/panel2.png') }}" alt="Logo" class="logo">
        </a>
    </div>
    <nav>
        <ul class="nav-links">
            <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li><a href="{{ route('admin.products') }}">Məhsullar</a></li>
            <li><a href="{{ route('admin.users') }}">İstifadəçilər</a></li>
            <li><a href="{{ route('admin.orders') }}">Sifarişlər</a></li>
            <li><a href="{{ route('admin.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Çıxın</a></li>
        </ul>
    </nav>
</header>

<!-- Arka Plan -->
<div class="background-overlay"></div>

<!-- Ana İçerik -->
<main class="admin-content">
    @yield('content')
</main>

<!-- Gizli Çıkış Formu -->
<form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
    @csrf
</form>
</body>
</html>
