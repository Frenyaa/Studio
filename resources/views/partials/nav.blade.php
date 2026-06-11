{{-- Thanh điều hướng: trong suốt trên hero, nền tối khi cuộn; có dropdown danh mục --}}
<header
    x-data="{ home: {{ request()->routeIs('home') ? 'true' : 'false' }}, scrolled: false, mobileOpen: false }"
    x-init="scrolled = !home"
    @scroll.window="if (home) scrolled = (window.pageYOffset > 60)"
    :class="scrolled ? 'bg-ink backdrop-blur shadow-[0_1px_0_0_rgba(0,0,0,0.06)] text-cream' : 'bg-transparent text-white'"
    class="fixed inset-x-0 top-0 z-50 transition-colors duration-500 ease-luxe"
>
    <nav class="mx-auto flex max-w-7xl items-center justify-between px-6 py-5 lg:px-10">
        {{-- Logo --}}
        <a href="{{ route('home') }}" class="font-brand text-2xl font-semibold tracking-luxe">
            @if (!empty($siteLogo))
                <img src="{{ asset('storage/' . $siteLogo) }}" alt="{{ $siteName ?? config('app.name') }}" class="h-8 w-auto">
            @else
                {{ strtoupper($siteName ?? config('app.name')) }}
            @endif
        </a>

        {{-- Menu desktop --}}
        <ul class="hidden items-center gap-9 text-xs font-medium uppercase tracking-luxe lg:flex">
            <li><a href="{{ route('home') }}" class="transition-colors duration-300 hover:text-accent">Trang chủ</a></li>

            {{-- Sản phẩm + dropdown loại --}}
            <li class="group relative">
                <a href="{{ route('products.index') }}" class="flex items-center gap-1 transition-colors duration-300 hover:text-accent">
                    Sản phẩm
                    <svg class="h-3 w-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5"/></svg>
                </a>
                @if (!empty($navProductCategories) && $navProductCategories->isNotEmpty())
                    <div class="invisible absolute left-1/2 top-full z-50 w-56 -translate-x-1/2 pt-4 opacity-0 transition-all duration-200 group-hover:visible group-hover:opacity-100">
                        <ul class="border border-line bg-ink py-2 text-cream shadow-2xl">
                            @foreach ($navProductCategories as $c)
                                <li><a href="{{ route('products.index', ['category' => $c->slug]) }}" class="block px-5 py-2.5 font-sans text-[11px] font-medium uppercase tracking-[0.14em] text-cream/70 transition-colors hover:bg-ink-soft hover:text-accent">{{ $c->name }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </li>

            {{-- Dự án + dropdown loại công trình --}}
            <li class="group relative">
                <a href="{{ route('projects.index') }}" class="flex items-center gap-1 transition-colors duration-300 hover:text-accent">
                    Dự án
                    <svg class="h-3 w-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5"/></svg>
                </a>
                @if (!empty($navProjectCategories) && $navProjectCategories->isNotEmpty())
                    <div class="invisible absolute left-1/2 top-full z-50 w-56 -translate-x-1/2 pt-4 opacity-0 transition-all duration-200 group-hover:visible group-hover:opacity-100">
                        <ul class="border border-line bg-ink py-2 text-cream shadow-2xl">
                            @foreach ($navProjectCategories as $c)
                                <li><a href="{{ route('projects.index', ['category' => $c->slug]) }}" class="block px-5 py-2.5 font-sans text-[11px] font-medium uppercase tracking-[0.14em] text-cream/70 transition-colors hover:bg-ink-soft hover:text-accent">{{ $c->name }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </li>

            <li><a href="{{ route('about') }}" class="transition-colors duration-300 hover:text-accent">Về chúng tôi</a></li>

            {{-- Blog + dropdown chủ đề --}}
            <li class="group relative">
                <a href="{{ route('blog.index') }}" class="flex items-center gap-1 transition-colors duration-300 hover:text-accent">
                    Blog
                    <svg class="h-3 w-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5"/></svg>
                </a>
                @if (!empty($navBlogCategories))
                    <div class="invisible absolute left-1/2 top-full z-50 w-56 -translate-x-1/2 pt-4 opacity-0 transition-all duration-200 group-hover:visible group-hover:opacity-100">
                        <ul class="border border-line bg-ink py-2 text-cream shadow-2xl">
                            @foreach ($navBlogCategories as $slug => $label)
                                <li><a href="{{ route('blog.index', ['category' => $slug]) }}" class="block px-5 py-2.5 font-sans text-[11px] font-medium uppercase tracking-[0.14em] text-cream/70 transition-colors hover:bg-ink-soft hover:text-accent">{{ $label }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </li>

            <li><a href="{{ route('contact') }}" class="transition-colors duration-300 hover:text-accent">Liên hệ</a></li>
        </ul>

        {{-- Nút hamburger mobile --}}
        <button @click="mobileOpen = true" class="lg:hidden" aria-label="Mở menu">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" d="M3.75 6.75h16.5M3.75 12h16.5M3.75 17.25h16.5" />
            </svg>
        </button>
    </nav>

    {{-- Overlay menu mobile --}}
    <div
        x-cloak
        x-show="mobileOpen"
        x-transition.opacity
        style="background-color:#f6f1e7; z-index:100;"
        class="fixed inset-0 h-screen w-screen overflow-y-auto text-cream lg:hidden"
    >
        <div class="flex items-center justify-between px-6 py-5">
            @if (!empty($siteLogo))
                <img src="{{ asset('storage/' . $siteLogo) }}" alt="{{ $siteName ?? config('app.name') }}" class="h-8 w-auto">
            @else
                <span class="font-brand text-2xl tracking-luxe">{{ strtoupper($siteName ?? config('app.name')) }}</span>
            @endif
            <button @click="mobileOpen = false" aria-label="Đóng menu">
                <svg class="h-7 w-7" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <ul class="mt-6 flex flex-col items-center gap-6 pb-16 font-serif text-3xl">
            <li><a @click="mobileOpen = false" class="hover:text-accent" href="{{ route('home') }}">Trang chủ</a></li>

            {{-- Sản phẩm + loại --}}
            <li class="flex flex-col items-center gap-2">
                <a @click="mobileOpen = false" class="hover:text-accent" href="{{ route('products.index') }}">Sản phẩm</a>
                @if (!empty($navProductCategories) && $navProductCategories->isNotEmpty())
                    <div class="flex max-w-xs flex-wrap justify-center gap-x-4 gap-y-1 font-sans text-xs uppercase tracking-luxe text-cream/50">
                        @foreach ($navProductCategories as $c)
                            <a @click="mobileOpen = false" class="hover:text-accent" href="{{ route('products.index', ['category' => $c->slug]) }}">{{ $c->name }}</a>
                        @endforeach
                    </div>
                @endif
            </li>

            {{-- Dự án + loại --}}
            <li class="flex flex-col items-center gap-2">
                <a @click="mobileOpen = false" class="hover:text-accent" href="{{ route('projects.index') }}">Dự án</a>
                @if (!empty($navProjectCategories) && $navProjectCategories->isNotEmpty())
                    <div class="flex max-w-xs flex-wrap justify-center gap-x-4 gap-y-1 font-sans text-xs uppercase tracking-luxe text-cream/50">
                        @foreach ($navProjectCategories as $c)
                            <a @click="mobileOpen = false" class="hover:text-accent" href="{{ route('projects.index', ['category' => $c->slug]) }}">{{ $c->name }}</a>
                        @endforeach
                    </div>
                @endif
            </li>

            <li><a @click="mobileOpen = false" class="hover:text-accent" href="{{ route('about') }}">Về chúng tôi</a></li>

            {{-- Blog + chủ đề --}}
            <li class="flex flex-col items-center gap-2">
                <a @click="mobileOpen = false" class="hover:text-accent" href="{{ route('blog.index') }}">Blog</a>
                @if (!empty($navBlogCategories))
                    <div class="flex max-w-xs flex-wrap justify-center gap-x-4 gap-y-1 font-sans text-xs uppercase tracking-luxe text-cream/50">
                        @foreach ($navBlogCategories as $slug => $label)
                            <a @click="mobileOpen = false" class="hover:text-accent" href="{{ route('blog.index', ['category' => $slug]) }}">{{ $label }}</a>
                        @endforeach
                    </div>
                @endif
            </li>

            <li><a @click="mobileOpen = false" class="hover:text-accent" href="{{ route('contact') }}">Liên hệ</a></li>
        </ul>
    </div>
</header>
