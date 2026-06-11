{{-- DẢI CTA TƯ VẤN: nền video (link) hoặc ảnh — chỉnh trong Admin → Cài đặt website → Dải CTA --}}
@php
    $c = $settings ?? [];
    $ctaEyebrow = ($c['cta_eyebrow'] ?? '') ?: 'Bắt đầu hành trình';
    $ctaTitle = ($c['cta_title'] ?? '') ?: 'Tìm món nội thất hoàn hảo cho ngôi nhà của bạn';
    $ctaSubtitle = ($c['cta_subtitle'] ?? '') ?: 'Để chuyên viên của chúng tôi tư vấn chọn sản phẩm, phối màu và kích thước phù hợp — giúp bạn sở hữu không gian sống đúng gu và đẳng cấp.';
    $ctaButton = ($c['cta_button'] ?? '') ?: 'Nhận tư vấn miễn phí';

    // Ảnh nền (link ưu tiên hơn upload, cuối cùng là ảnh mặc định)
    $ctaImageUrl = trim((string) ($c['cta_image_url'] ?? ''));
    $ctaImagePath = $c['cta_image'] ?? '';
    $ctaBg = $ctaImageUrl !== ''
        ? $ctaImageUrl
        : ($ctaImagePath ? asset('storage/' . $ctaImagePath) : asset('storage/placeholders/project-5.jpg'));

    // Video nền (link): YouTube / Vimeo (iframe) hoặc MP4 trực tiếp (video)
    $ctaVideoUrl = trim((string) ($c['cta_video_url'] ?? ''));
    $ctaEmbed = null;
    $ctaVideo = null;
    if ($ctaVideoUrl !== '') {
        if (preg_match('~(?:youtube\.com/(?:watch\?v=|embed/|shorts/)|youtu\.be/)([\w-]{11})~', $ctaVideoUrl, $m)) {
            $ctaEmbed = "https://www.youtube.com/embed/{$m[1]}?autoplay=1&mute=1&loop=1&playlist={$m[1]}&controls=0&showinfo=0&modestbranding=1&playsinline=1&rel=0";
        } elseif (preg_match('~vimeo\.com/(?:video/)?(\d+)~', $ctaVideoUrl, $m)) {
            $ctaEmbed = "https://player.vimeo.com/video/{$m[1]}?autoplay=1&muted=1&loop=1&background=1";
        } else {
            $ctaVideo = $ctaVideoUrl;
        }
    }
@endphp
<section class="relative overflow-hidden">
    {{-- Nền: video (nếu có) hoặc ảnh --}}
    @if ($ctaEmbed)
        <div class="absolute inset-0 overflow-hidden">
            <iframe class="pointer-events-none absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2"
                style="width:100vw;height:56.25vw;min-height:100%;min-width:177.78vh;"
                src="{{ $ctaEmbed }}" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen title="CTA video"></iframe>
        </div>
    @elseif ($ctaVideo)
        <video class="absolute inset-0 h-full w-full object-cover" autoplay muted loop playsinline poster="{{ $ctaBg }}">
            <source src="{{ $ctaVideo }}" type="video/mp4">
        </video>
    @else
        <div class="absolute inset-0 bg-cover bg-center bg-fixed" style="background-image:url('{{ $ctaBg }}')"></div>
    @endif

    <div class="absolute inset-0 bg-black/55"></div>

    <div class="reveal relative z-10 mx-auto flex max-w-3xl flex-col items-center px-6 py-28 text-center text-white lg:py-40">
        <p class="text-xs font-medium uppercase tracking-luxe text-white/70">{{ $ctaEyebrow }}</p>
        <h2 class="mt-5 font-serif text-4xl font-light leading-tight tracking-wide lg:text-5xl">{{ $ctaTitle }}</h2>
        <p class="mt-6 max-w-xl leading-relaxed text-white/80">{{ $ctaSubtitle }}</p>
        <a href="#contact" class="btn-line mt-10 border-white/70 text-white hover:bg-white hover:text-cream">
            {{ $ctaButton }}
            <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25 21 12m0 0-3.75 3.75M21 12H3"/></svg>
        </a>
    </div>
</section>
