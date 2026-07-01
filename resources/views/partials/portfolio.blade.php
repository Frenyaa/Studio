{{-- DỰ ÁN CỦA ANN: lưới hình ảnh khổ lớn, hover zoom + hiện tên --}}
<section id="portfolio" class="bg-gradient-to-b from-ink to-ink-soft py-8 lg:py-12">
    <div class="mx-auto max-w-[85rem] px-6 lg:px-10">
        {{-- Tiêu đề section --}}
        <div class="reveal mb-6 text-center">
            <p class="eyebrow">Portfolio</p>
            <h2 class="mt-3 font-serif text-4xl font-light tracking-wide lg:text-5xl">Dự Án Nổi Bật</h2>
            <div class="mx-auto mt-4 h-px w-16 bg-accent/70"></div>
        </div>

        @if ($featuredProjects->isEmpty())
            <p class="text-center text-cream/70">Chưa có dự án nổi bật. Hãy thêm dự án trong trang quản trị.</p>
        @else
            {{-- Lưới dự án --}}
            <div class="flex flex-wrap justify-center gap-8">
                @foreach ($featuredProjects as $project)
                    <a href="{{ route('projects.show', $project) }}" class="group reveal flex flex-col bg-ink-soft/10 p-5 border border-line/20 rounded-sm hover:border-accent/40 transition-colors duration-500 w-full sm:w-[calc(50%-16px)] lg:w-[calc(33.333%-22px)] max-w-[420px] lg:max-w-none">
                        <div class="relative overflow-hidden bg-ink aspect-[4/3] w-full rounded-sm">
                            <img src="{{ Str::startsWith($project->grid_image, 'http') ? $project->grid_image : asset('storage/' . $project->grid_image) }}" alt="{{ $project->title }}" loading="lazy"
                                 class="absolute inset-0 h-full w-full object-cover transition-transform duration-[1400ms] ease-luxe group-hover:scale-105">
                            <div class="absolute inset-0 bg-black/0 transition-colors duration-500 group-hover:bg-black/25"></div>
                        </div>

                        <div class="pt-5 flex flex-col justify-between flex-1">
                            <div>
                                <div class="flex items-baseline justify-between">
                                    <h3 class="font-serif text-xl font-light text-cream group-hover:text-accent transition-colors duration-300">{{ $project->title }}</h3>
                                    @if ($project->category)
                                        <span class="text-[10px] uppercase tracking-luxe text-cream/50 ml-2 flex-shrink-0">{{ $project->category->name }}</span>
                                    @endif
                                </div>
                                
                                @if ($project->location)
                                    <p class="mt-1 text-[10px] uppercase tracking-luxe text-cream/50">{{ $project->location }}</p>
                                @endif

                                @if ($project->summary)
                                    <p class="mt-3 text-xs leading-relaxed text-cream/70 line-clamp-3">
                                        {{ $project->summary }}
                                    </p>
                                @endif
                            </div>
                        </div>
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
