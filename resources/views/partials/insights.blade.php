{{-- CẢM HỨNG / GÓC TƯ VẤN: 3 bài viết mới nhất (phong cách buyer's guide) --}}
@if (isset($posts) && $posts->isNotEmpty())
<section id="insights" class="bg-cream py-24 lg:py-32">
    <div class="mx-auto max-w-7xl px-6 lg:px-10">
        <div class="reveal mb-16 flex flex-col items-center text-center">
            <p class="eyebrow">Cảm hứng</p>
            <h2 class="mt-4 font-serif text-4xl font-light tracking-wide lg:text-5xl">Góc Tư Vấn & Xu Hướng</h2>
            <div class="mx-auto mt-6 h-px w-16 bg-ink/30"></div>
        </div>

        <div class="grid grid-cols-1 gap-x-8 gap-y-12 md:grid-cols-3">
            @foreach ($posts as $post)
                <a href="{{ route('blog.show', $post) }}" class="group reveal reveal-d{{ ($loop->index % 3) + 1 }} block">
                    <div class="relative overflow-hidden bg-ink">
                        <div class="aspect-[4/3] w-full overflow-hidden">
                            @if ($post->cover_image)
                                <img src="{{ asset('storage/' . $post->cover_image) }}" alt="{{ $post->title }}" loading="lazy"
                                     class="h-full w-full object-cover transition-transform duration-[1400ms] ease-luxe group-hover:scale-105">
                            @endif
                        </div>
                    </div>
                    @if ($post->category)
                        <p class="mt-5 text-[11px] uppercase tracking-luxe text-ink-muted">{{ $post->category }}</p>
                    @endif
                    <h3 class="mt-2 font-serif text-2xl font-light leading-snug text-ink transition-colors group-hover:text-ink-soft">{{ $post->title }}</h3>
                    @if ($post->excerpt)
                        <p class="mt-3 text-sm leading-relaxed text-ink-muted line-clamp-2">{{ $post->excerpt }}</p>
                    @endif
                    <span class="mt-4 inline-flex items-center gap-2 text-xs font-medium uppercase tracking-luxe text-ink">
                        Đọc tiếp
                        <svg class="h-4 w-4 transition-transform duration-500 ease-luxe group-hover:translate-x-1" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25 21 12m0 0-3.75 3.75M21 12H3"/></svg>
                    </span>
                </a>
            @endforeach
        </div>

        <div class="reveal mt-16 text-center">
            <a href="{{ route('blog.index') }}" class="btn-line border-ink/70 text-ink hover:bg-ink hover:text-cream">
                Xem tất cả bài viết
                <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25 21 12m0 0-3.75 3.75M21 12H3"/></svg>
            </a>
        </div>
    </div>
</section>
@endif
