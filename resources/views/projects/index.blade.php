@extends('layouts.app')

@section('title', 'Dự án — ' . config('app.name'))

@section('content')
    <section class="bg-cream pt-32 pb-20 lg:pt-40">
        <div class="mx-auto max-w-7xl px-6 lg:px-10">
            {{-- Tiêu đề --}}
            <div class="mb-12 text-center">
                <p class="text-xs font-medium uppercase tracking-luxe text-ink-muted">Portfolio</p>
                <h1 class="mt-4 font-serif text-4xl font-light tracking-wide lg:text-6xl">Toàn Bộ Dự Án</h1>
            </div>

            {{-- Bộ lọc danh mục --}}
            <div class="mb-14 flex flex-wrap items-center justify-center gap-x-8 gap-y-3 text-xs font-medium uppercase tracking-luxe">
                <a href="{{ route('projects.index') }}"
                   class="border-b-2 pb-1 transition-colors {{ ! request('category') ? 'border-ink text-ink' : 'border-transparent text-ink-muted hover:text-ink' }}">
                    Tất cả
                </a>
                @foreach ($categories as $category)
                    <a href="{{ route('projects.index', ['category' => $category->slug]) }}"
                       class="border-b-2 pb-1 transition-colors {{ request('category') === $category->slug ? 'border-ink text-ink' : 'border-transparent text-ink-muted hover:text-ink' }}">
                        {{ $category->name }}
                    </a>
                @endforeach
            </div>

            {{-- Lưới dự án --}}
            @if ($projects->isEmpty())
                <p class="text-center text-ink-muted">Chưa có dự án nào.</p>
            @else
                <div class="grid grid-cols-1 gap-x-6 gap-y-12 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($projects as $project)
                        <a href="{{ route('projects.show', $project) }}" class="group block">
                            <div class="relative overflow-hidden bg-ink">
                                <div class="aspect-[3/4] w-full overflow-hidden">
                                    <img src="{{ asset('storage/' . $project->grid_image) }}" alt="{{ $project->title }}" loading="lazy"
                                         class="h-full w-full object-cover transition-transform duration-[1400ms] ease-luxe group-hover:scale-105">
                                </div>
                                <div class="absolute inset-0 bg-ink/0 transition-colors duration-500 group-hover:bg-ink/15"></div>
                            </div>

                            <div class="mt-5 flex items-baseline justify-between">
                                <div>
                                    <h3 class="font-serif text-2xl font-light text-ink">{{ $project->title }}</h3>
                                    @if ($project->location)
                                        <p class="mt-1 text-xs uppercase tracking-luxe text-ink-muted">{{ $project->location }}</p>
                                    @endif
                                </div>
                                @if ($project->category)
                                    <span class="text-[11px] uppercase tracking-luxe text-ink-muted">{{ $project->category->name }}</span>
                                @endif
                            </div>

                            @if ($project->summary)
                                <p class="mt-3 border-t border-line pt-4 text-sm leading-relaxed text-ink-muted line-clamp-2 transition-colors duration-500 group-hover:border-ink/40">
                                    {{ $project->summary }}
                                </p>
                            @endif
                        </a>
                    @endforeach
                </div>

                <div class="mt-16">
                    {{ $projects->links() }}
                </div>
            @endif
        </div>
    </section>
@endsection
