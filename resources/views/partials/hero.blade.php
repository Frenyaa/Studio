{{-- HERO: Video nền toàn màn hình, lazy-load, overlay logo mờ dần khi cuộn --}}
<section
    x-data="heroSection()"
    class="relative h-screen w-full overflow-hidden bg-ink"
>
    {{-- Video nền (muted, loop, autoplay, playsinline). Dùng poster để lazy hiển thị tức thì. --}}
    @php
        $videoSrc = $hero?->video_source;
        $poster = $hero?->poster_image ? asset('storage/' . $hero->poster_image) : null;
    @endphp

    @if ($videoSrc)
        <video
            class="absolute inset-0 h-full w-full object-cover"
            autoplay muted loop playsinline preload="none"
            @if($poster) poster="{{ $poster }}" @endif
            x-ref="video"
        >
            <source data-src="{{ $videoSrc }}" type="video/mp4">
        </video>
    @elseif ($poster)
        <img src="{{ $poster }}" alt="{{ config('app.name') }}" class="absolute inset-0 h-full w-full object-cover animate-slow-zoom">
    @else
        {{-- Fallback nền tối khi chưa cấu hình hero trong admin --}}
        <div class="absolute inset-0 bg-gradient-to-b from-ink-soft to-ink"></div>
    @endif

    {{-- Lớp phủ mờ tối giản, nhẹ để giữ độ sáng của ảnh --}}
    <div class="absolute inset-0 bg-ink/25"></div>
    <div class="absolute inset-0 bg-gradient-to-t from-ink/70 via-ink/10 to-ink/20"></div>

    {{-- Logo phóng to mờ dần khi cuộn --}}
    @if ($hero?->show_logo_overlay ?? true)
        <div
            class="pointer-events-none absolute inset-0 flex items-center justify-center"
            :style="`opacity:${logoOpacity}; transform:scale(${logoScale})`"
        >
            <span class="font-serif text-[18vw] font-light leading-none tracking-luxe text-white/10 lg:text-[12vw]">
                {{ strtoupper(config('app.name')) }}
            </span>
        </div>
    @endif

    {{-- Nội dung overlay --}}
    <div class="relative z-10 flex h-full flex-col items-center justify-center px-6 text-center text-white">
        <h1 class="max-w-4xl font-serif text-4xl font-light leading-tight tracking-wide animate-fade-up sm:text-5xl lg:text-6xl">
            {{ $hero?->slogan ?? 'NỘI THẤT CAO CẤP CHO KHÔNG GIAN SỐNG TINH TẾ' }}
        </h1>

        @if ($hero?->sub_slogan)
            <p class="mt-6 max-w-xl text-sm font-light uppercase tracking-luxe text-white/80 animate-fade-up">
                {{ $hero->sub_slogan }}
            </p>
        @endif

        <a
            href="{{ $hero?->cta_anchor ?? '#categories' }}"
            class="btn-line mt-12 border-white/70 text-white hover:bg-white hover:text-ink"
        >
            {{ $hero?->cta_label ?? 'XEM SẢN PHẨM' }}
            <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25 21 12m0 0-3.75 3.75M21 12H3" /></svg>
        </a>
    </div>

    {{-- Chỉ báo cuộn xuống --}}
    <div class="absolute bottom-8 left-1/2 z-10 -translate-x-1/2 text-white/70">
        <svg class="h-6 w-6 animate-bounce" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
        </svg>
    </div>
</section>

@push('scripts')
<script>
function heroSection() {
    return {
        logoOpacity: 1,
        logoScale: 1,
        init() {
            // Lazy-load video: chỉ gán src khi vào trang để không chặn render đầu tiên.
            this.$nextTick(() => {
                const video = this.$refs.video;
                if (video) {
                    const source = video.querySelector('source[data-src]');
                    if (source && !source.src) {
                        source.src = source.dataset.src;
                        video.load();
                        video.play().catch(() => {});
                    }
                }
            });

            // Logo mờ dần + phóng to nhẹ khi cuộn.
            window.addEventListener('scroll', () => {
                const y = window.pageYOffset;
                const max = window.innerHeight;
                this.logoOpacity = Math.max(0, 1 - (y / (max * 0.6)));
                this.logoScale = 1 + (y / max) * 0.4;
            }, { passive: true });
        }
    }
}
</script>
@endpush
