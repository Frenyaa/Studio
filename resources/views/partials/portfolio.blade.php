{{-- DỰ ÁN CỦA ANN: lưới hình ảnh khổ lớn, hover zoom + hiện tên --}}
<section id="portfolio" class="bg-ink py-24 lg:py-32">
    <div class="mx-auto max-w-7xl px-6 lg:px-10">
        {{-- Tiêu đề section --}}
        <div class="reveal mb-16 text-center">
            <p class="eyebrow">Portfolio</p>
            <h2 class="mt-4 font-serif text-4xl font-light tracking-wide lg:text-5xl">Dự Án Nổi Bật</h2>
            <div class="mx-auto mt-6 h-px w-16 bg-accent/70"></div>
        </div>

        @if ($featuredProjects->isEmpty())
            <p class="text-center text-cream/70">Chưa có dự án nổi bật. Hãy thêm dự án trong trang quản trị.</p>
        @else
            {{-- Lưới dự án --}}
            <div class="grid grid-cols-1 gap-x-6 gap-y-12 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($featuredProjects as $project)
                    <a
                        href="{{ route('projects.show', $project) }}"
                        class="group reveal reveal-d{{ ($loop->index % 3) + 1 }} block"
                    >
                        <div class="relative overflow-hidden bg-ink">
                            <div class="aspect-[3/4] w-full overflow-hidden">
                                <img
                                    src="{{ asset('storage/' . $project->grid_image) }}"
                                    alt="{{ $project->title }}"
                                    loading="lazy"
                                    class="h-full w-full object-cover transition-transform duration-[1400ms] ease-luxe group-hover:scale-105"
                                >
                            </div>
                            {{-- Lớp phủ tinh tế khi hover --}}
                            <div class="absolute inset-0 bg-ink/0 transition-colors duration-500 group-hover:bg-ink/15"></div>
                        </div>

                        {{-- Caption sạch hiển thị bên dưới (phong cách editorial) --}}
                        <div class="mt-5 flex items-baseline justify-between transition-colors duration-500">
                            <div>
                                <h3 class="font-serif text-2xl font-light text-cream">{{ $project->title }}</h3>
                                @if ($project->location)
                                    <p class="mt-1 text-xs uppercase tracking-luxe text-cream/70">{{ $project->location }}</p>
                                @endif
                            </div>
                            @if ($project->category)
                                <span class="text-[11px] uppercase tracking-luxe text-cream/70">{{ $project->category->name }}</span>
                            @endif
                        </div>

                        {{-- Mô tả ngắn --}}
                        @if ($project->summary)
                            <p class="mt-3 border-t border-line pt-4 text-sm leading-relaxed text-cream/70 line-clamp-2 transition-colors duration-500 group-hover:border-cream/40">
                                {{ $project->summary }}
                            </p>
                        @endif
                    </a>
                @endforeach
            </div>

            {{-- CTA xem toàn bộ --}}
            <div class="reveal mt-16 text-center">
                <a href="{{ route('projects.index') }}" class="btn-line border-cream/70 text-cream hover:bg-cream hover:text-ink">
                    Xem toàn bộ dự án
                    <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25 21 12m0 0-3.75 3.75M21 12H3" /></svg>
                </a>
            </div>
        @endif
    </div>
</section>
