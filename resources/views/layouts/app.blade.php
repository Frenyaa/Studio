<!DOCTYPE html>
<html lang="vi" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name') . ' — Nội Thất Cao Cấp | Tối Giản Sang Trọng')</title>
    <meta name="description" content="@yield('meta_description', config('app.name') . ' — Thương hiệu nội thất cao cấp phong cách tối giản sang trọng. Sofa, bàn ghế, giường tủ thiết kế tinh tế cho không gian sống đẳng cấp.')">

    {{-- Preconnect & font Serif thanh lịch --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;500;600;700&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-cream text-ink font-sans antialiased selection:bg-ink selection:text-cream">

    @include('partials.nav')

    <main>
        @yield('content')
    </main>

    @include('partials.footer')

    @stack('scripts')
</body>
</html>
