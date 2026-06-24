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
            <div class="grid grid-cols-1 gap-8 lg:grid-cols-2 lg:items-stretch">
                {{-- Cột trái: 1 Item To (50%) --}}
                @if(isset($featuredProjects[0]))
                    @php $firstProject = $featuredProjects[0]; @endphp
                    <a href="{{ route('projects.show', $firstProject) }}" class="group reveal flex flex-col h-full bg-ink-soft/10 p-6 border border-line/20 rounded-sm hover:border-accent/40 transition-colors duration-500">
                        <div class="relative overflow-hidden bg-ink flex-1 min-h-[380px] lg:min-h-0 rounded-sm">
                            <img src="{{ Str::startsWith($firstProject->grid_image, 'http') ? $firstProject->grid_image : asset('storage/' . $firstProject->grid_image) }}" alt="{{ $firstProject->title }}" loading="lazy"
                                 class="absolute inset-0 h-full w-full object-cover transition-transform duration-[1400ms] ease-luxe group-hover:scale-105">
                            <div class="absolute inset-0 bg-black/0 transition-colors duration-500 group-hover:bg-black/25"></div>
                        </div>

                        <div class="pt-5 flex flex-col justify-between">
                            <div class="flex items-baseline justify-between">
                                <div>
                                    <h3 class="font-serif text-2xl font-light text-cream group-hover:text-accent transition-colors duration-300">{{ $firstProject->title }}</h3>
                                    @if ($firstProject->location)
                                        <p class="mt-1 text-[11px] uppercase tracking-luxe text-cream/50">{{ $firstProject->location }}</p>
                                    @endif
                                </div>
                                @if ($firstProject->category)
                                    <span class="text-[11px] uppercase tracking-luxe text-cream/50">{{ $firstProject->category->name }}</span>
                                @endif
                            </div>

                            @if ($firstProject->summary)
                                <p class="mt-4 border-t border-line/20 pt-4 text-sm leading-relaxed text-cream/80 line-clamp-2">
                                    {{ $firstProject->summary }}
                                </p>
                            @endif
                        </div>
                    </a>
                @endif

                {{-- Cột phải: 2 Items nằm ngang xếp chồng (50%) --}}
                <div class="flex flex-col justify-between gap-6">
                    @foreach ($featuredProjects->slice(1, 2) as $project)
                        <a href="{{ route('projects.show', $project) }}" class="group reveal flex flex-row gap-6 p-6 bg-ink-soft/10 border border-line/20 rounded-sm h-full lg:h-[calc(50%-12px)] items-stretch hover:border-accent/40 transition-colors duration-500">
                            <div class="relative overflow-hidden bg-ink w-[32%] lg:w-[180px] xl:w-[200px] flex-shrink-0 rounded-sm h-full min-h-[140px] lg:min-h-0">
                                <img src="{{ Str::startsWith($project->grid_image, 'http') ? $project->grid_image : asset('storage/' . $project->grid_image) }}" alt="{{ $project->title }}" loading="lazy"
                                     class="absolute inset-0 h-full w-full object-cover transition-transform duration-[1400ms] ease-luxe group-hover:scale-105">
                                <div class="absolute inset-0 bg-black/0 transition-colors duration-500 group-hover:bg-black/25"></div>
                            </div>

                            <div class="flex-1 flex flex-col justify-between py-1">
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
