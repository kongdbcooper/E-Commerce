<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title') | Pawland</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<script src="../js/script.js" defer></script>
<script src="../js/navigation.js" defer></script>

<body>
    <div>
        <header>
            <nav>
                <div class="nav-wrapper">
                    <div class="logo">🐾 Pawland</div>
                    <ul class="nav-links">
                        <li><a class="active" href="{{ Route('photos.home') }}"">🏠 หน้าแรก</a></li>
                        <li><a href="{{ Route('photos.index') }}">🛍️ สินค้า</a></li>
                        <li><a href="{{ Route('photos.about') }}">ℹ️ เกี่ยวกับเรา</a></li>
                        <li><a href="{{ Route('photos.contact') }}">📧 ติดต่อ</a></li>
                        @auth
                            @if (auth()->user()->role === 'admin')
                             <li><a href="{{ Route('dashboard') }}">จัดการสินค้า</a></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="nav-link">
                                            🚪 ออกจากระบบ
                                        </button>
                                    </form>
                                </li>
                            @endif
                        @endauth
                        {{-- <li><a href="#">เข้าสู่ระบบ</a></li> --}}
                    </ul>
                </div>
            </nav>
        </header>
    </div>
    <div>
        @yield('content')
    </div>
    <div>
        @extends('layouts.footer')
    </div>
</body>

</html>
