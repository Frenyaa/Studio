{{-- Thanh điều hướng tối giản: trong suốt trên hero, chuyển nền kem khi cuộn --}}
<header
    x-data="{ scrolled: false, mobileOpen: false }"
    @scroll.window="scrolled = (window.pageYOffset > 60)"
    :class="scrolled ? 'bg-cream/95 backdrop-blur shadow-[0_1px_0_0_rgba(0,0,0,0.06)] text-ink' : 'bg-transparent text-white'"
    class="fixed inset-x-0 top-0 z-50 transition-colors duration-500 ease-luxe"
>
    <nav class="mx-auto flex max-w-7xl items-center justify-between px-6 py-5 lg:px-10">
        {{-- Logo --}}
        <a href="{{ route('home') }}" class="font-serif text-2xl font-semibold tracking-luxe">
            {{ strtoupper(config('app.name')) }}
        </a>

        {{-- Menu desktop --}}
        <ul class="hidden items-center gap-10 text-xs font-medium uppercase tracking-luxe lg:flex">
            <li><a href="{{ route('home') }}" class="transition-opacity hover:opacity-60">Trang chủ</a></li>
            <li><a href="{{ route('projects.index') }}" class="transition-opacity hover:opacity-60">Dự án</a></li>
            <li><a href="{{ route('home') }}#services" class="transition-opacity hover:opacity-60">Dịch vụ</a></li>
            <li><a href="{{ route('home') }}#about" class="transition-opacity hover:opacity-60">Về chúng tôi</a></li>
            <li><a href="{{ route('blog.index') }}" class="transition-opacity hover:opacity-60">Cảm hứng</a></li>
            <li><a href="{{ route('home') }}#contact" class="transition-opacity hover:opacity-60">Liên hệ</a></li>
        </ul>

        {{-- Nút hamburger mobile --}}
        <button @click="mobileOpen = true" class="lg:hidden" aria-label="Mở menu">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" d="M3.75 6.75h16.5M3.75 12h16.5M3.75 17.25h16.5" />
            </svg>
        </button>
    </nav>

    {{-- Overlay menu mobile (Alpine) --}}
    <div
        x-cloak
        x-show="mobileOpen"
        x-transition.opacity
        class="fixed inset-0 z-50 bg-ink/95 text-cream lg:hidden"
    >
        <div class="flex items-center justify-between px-6 py-5">
            <span class="font-serif text-2xl tracking-luxe">{{ strtoupper(config('app.name')) }}</span>
            <button @click="mobileOpen = false" aria-label="Đóng menu">
                <svg class="h-7 w-7" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <ul class="mt-10 flex flex-col items-center gap-8 font-serif text-3xl">
            <li><a @click="mobileOpen = false" href="{{ route('home') }}">Trang chủ</a></li>
            <li><a @click="mobileOpen = false" href="{{ route('projects.index') }}">Dự án</a></li>
            <li><a @click="mobileOpen = false" href="{{ route('home') }}#services">Dịch vụ</a></li>
            <li><a @click="mobileOpen = false" href="{{ route('home') }}#about">Về chúng tôi</a></li>
            <li><a @click="mobileOpen = false" href="{{ route('blog.index') }}">Cảm hứng</a></li>
            <li><a @click="mobileOpen = false" href="{{ route('home') }}#contact">Liên hệ</a></li>
        </ul>
    </div>
</header>
