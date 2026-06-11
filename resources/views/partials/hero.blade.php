{{-- HERO: Video nền toàn màn hình, lazy-load, overlay logo mờ dần khi cuộn --}}
<section
    x-data="heroSection()"
    class="relative h-screen w-full overflow-hidden bg-ink"
>
    {{-- Video nền: ưu tiên file upload → link YouTube/Vimeo → link MP4 trực tiếp → ảnh poster. --}}
    @php
        $poster = $hero?->poster_source;
        $videoFile = $hero?->video_file ? asset('storage/' . $hero->video_file) : null;
        $rawUrl = trim((string) ($hero?->video_url ?? ''));

        $embedUrl = null;
        $directVideo = $videoFile;

        if (! $videoFile && $rawUrl !== '') {
            if (preg_match('~(?:youtube\.com/(?:watch\?v=|embed/|shorts/)|youtu\.be/)([\w-]{11})~', $rawUrl, $m)) {
                $embedUrl = "https://www.youtube.com/embed/{$m[1]}?autoplay=1&mute=1&loop=1&playlist={$m[1]}&controls=0&showinfo=0&modestbranding=1&playsinline=1&rel=0";
            } elseif (preg_match('~vimeo\.com/(?:video/)?(\d+)~', $rawUrl, $m)) {
                $embedUrl = "https://player.vimeo.com/video/{$m[1]}?autoplay=1&muted=1&loop=1&background=1";
            } else {
                $directVideo = $rawUrl; // link MP4 trực tiếp
            }
        }
    @endphp

    @if ($embedUrl)
        <div class="absolute inset-0 overflow-hidden">
            <iframe
                class="pointer-events-none absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2"
                style="width:100vw;height:56.25vw;min-height:100vh;min-width:177.78vh;"
                src="{{ $embedUrl }}"
                frameborder="0" allow="autoplay; encrypted-media" allowfullscreen title="hero video"
            ></iframe>
        </div>
    @elseif ($directVideo)
        <video
            class="absolute inset-0 h-full w-full object-cover"
            autoplay muted loop playsinline preload="none"
            @if($poster) poster="{{ $poster }}" @endif
            x-ref="video"
        >
            <source data-src="{{ $directVideo }}" type="video/mp4">
        </video>
    @elseif ($poster)
        <img src="{{ $poster }}" alt="{{ config('app.name') }}" class="absolute inset-0 h-full w-full object-cover animate-slow-zoom">
    @else
        {{-- Fallback nền tối khi chưa cấu hình hero trong admin --}}
        <div class="absolute inset-0 bg-gradient-to-b from-neutral-800 to-neutral-900"></div>
    @endif

    {{-- Lớp phủ mờ tối giản, nhẹ để giữ độ sáng của ảnh (luôn tối để chữ trắng dễ đọc) --}}
    <div class="absolute inset-0 bg-black/25"></div>
    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/10 to-black/20"></div>

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
            class="btn-line mt-12 border-white/70 text-white hover:bg-white hover:text-cream"
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
