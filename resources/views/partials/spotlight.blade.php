{{-- DỰ ÁN NỔI BẬT: khối 2 cột kể chuyện (phong cách lookbook) --}}
@if (!empty($spotlight))
<section class="bg-ink py-24 lg:py-32">
    <div class="mx-auto max-w-7xl px-6 lg:px-10">
        <div class="grid items-center gap-10 lg:grid-cols-2 lg:gap-16">
            {{-- Ảnh lớn --}}
            <div class="reveal overflow-hidden bg-ink">
                <a href="{{ route('projects.show', $spotlight) }}" class="group block">
                    <div class="aspect-[4/3] w-full overflow-hidden">
                        <img src="{{ asset('storage/' . $spotlight->cover_image) }}" alt="{{ $spotlight->title }}" loading="lazy"
                             class="h-full w-full object-cover transition-transform duration-[1400ms] ease-luxe group-hover:scale-105">
                    </div>
                </a>
            </div>

            {{-- Nội dung --}}
            <div class="reveal reveal-d2 lg:pl-6">
                <p class="eyebrow">Dự án nổi bật</p>
                <h2 class="mt-4 font-serif text-4xl font-light leading-tight tracking-wide lg:text-5xl">{{ $spotlight->title }}</h2>

                <div class="mt-6 flex flex-wrap gap-x-10 gap-y-3 text-xs uppercase tracking-luxe text-cream/70">
                    @if ($spotlight->category)<span>{{ $spotlight->category->name }}</span>@endif
                    @if ($spotlight->location)<span>{{ $spotlight->location }}</span>@endif
                    @if ($spotlight->area)<span>{{ $spotlight->area }}</span>@endif
                </div>

                @if ($spotlight->summary)
                    <p class="mt-8 max-w-lg leading-relaxed text-cream/70">{{ $spotlight->summary }}</p>
                @endif

                <a href="{{ route('projects.show', $spotlight) }}" class="btn-line mt-10 border-cream/70 text-cream hover:bg-cream hover:text-ink">
                    Khám phá dự án
                    <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25 21 12m0 0-3.75 3.75M21 12H3"/></svg>
                </a>
            </div>
        </div>
    </div>
</section>
@endif
