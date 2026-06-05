@extends('layouts.app')

@section('title', ($project->meta_title ?: $project->title) . ' — ' . config('app.name'))
@section('meta_description', $project->meta_description ?: $project->summary)

@php
    // Tập hợp ảnh: ảnh đại diện + thư viện
    $gallery = collect([$project->cover_image])
        ->merge($project->images->pluck('image'))
        ->filter()
        ->unique()
        ->map(fn ($img) => asset('storage/' . $img))
        ->values();
@endphp

@section('content')
    <div
        x-data="{ active: '{{ $gallery->first() }}', lightbox: false }"
        class="bg-cream pt-28 lg:pt-32"
    >
        <div class="mx-auto max-w-7xl px-6 lg:px-10">
            {{-- Breadcrumb --}}
            <nav class="border-b border-line py-5 text-xs uppercase tracking-luxe text-ink-muted">
                <a href="{{ route('home') }}" class="transition-colors hover:text-ink">Trang chủ</a>
                <span class="mx-2">/</span>
                <a href="{{ route('projects.index') }}" class="transition-colors hover:text-ink">Dự án</a>
                <span class="mx-2">/</span>
                <span class="text-ink">{{ $project->title }}</span>
            </nav>

            {{-- Bố cục 2 cột: Gallery | Thông tin --}}
            <div class="grid gap-10 py-12 lg:grid-cols-2 lg:gap-16">
                {{-- CỘT TRÁI: Gallery --}}
                <div>
                    <div class="group relative overflow-hidden bg-ink" @click="lightbox = true">
                        <div class="aspect-[4/3] w-full cursor-zoom-in overflow-hidden">
                            <img :src="active" alt="{{ $project->title }}" class="h-full w-full object-cover">
                        </div>
                        <span class="absolute bottom-4 right-4 flex h-10 w-10 items-center justify-center bg-cream/80 text-ink">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3.75v4.5m0-4.5h4.5m-4.5 0L9 9M3.75 20.25v-4.5m0 4.5h4.5m-4.5 0L9 15M20.25 3.75h-4.5m4.5 0v4.5m0-4.5L15 9m5.25 11.25h-4.5m4.5 0v-4.5m0 4.5L15 15"/></svg>
                        </span>
                    </div>

                    {{-- Thumbnails --}}
                    @if ($gallery->count() > 1)
                        <div class="mt-4 grid grid-cols-5 gap-3">
                            @foreach ($gallery as $img)
                                <button
                                    @click="active = '{{ $img }}'"
                                    :class="active === '{{ $img }}' ? 'ring-2 ring-ink' : 'opacity-70 hover:opacity-100'"
                                    class="aspect-square overflow-hidden bg-ink transition-all duration-300"
                                >
                                    <img src="{{ $img }}" alt="{{ $project->title }}" loading="lazy" class="h-full w-full object-cover">
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>

                {{-- CỘT PHẢI: Thông tin --}}
                <div class="lg:py-2">
                    <h1 class="font-serif text-4xl font-light leading-tight tracking-wide text-ink lg:text-5xl">{{ $project->title }}</h1>

                    <p class="mt-4 text-xs uppercase tracking-luxe text-ink-muted">
                        SKU: {{ $project->sku ?: strtoupper(Str::limit($project->slug, 20, '')) }}
                    </p>

                    <div class="my-7 h-px w-full bg-line"></div>

                    {{-- Nút tư vấn (không có giá / số lượng) --}}
                    <a
                        href="{{ route('home') }}#contact"
                        class="flex w-full items-center justify-center gap-3 bg-ink px-8 py-5 text-sm font-medium uppercase tracking-luxe text-cream transition-opacity duration-300 hover:opacity-90"
                    >
                        Gặp nhân viên tư vấn
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25 21 12m0 0-3.75 3.75M21 12H3"/></svg>
                    </a>

                    {{-- Mô tả + thông số --}}
                    <div class="mt-10">
                        <h2 class="font-serif text-2xl font-light text-ink">Mô tả</h2>

                        <dl class="mt-6 divide-y divide-line border-y border-line text-sm">
                            @if ($project->category)
                                <div class="flex gap-4 py-3"><dt class="w-36 shrink-0 font-medium text-ink">Loại hình</dt><dd class="text-ink-muted">{{ $project->category->name }}</dd></div>
                            @endif
                            @if ($project->dimensions)
                                <div class="flex gap-4 py-3"><dt class="w-36 shrink-0 font-medium text-ink">Kích thước</dt><dd class="text-ink-muted">{{ $project->dimensions }}</dd></div>
                            @endif
                            @if ($project->material)
                                <div class="flex gap-4 py-3"><dt class="w-36 shrink-0 font-medium text-ink">Chất liệu</dt><dd class="text-ink-muted whitespace-pre-line">{{ $project->material }}</dd></div>
                            @endif
                            @if ($project->colors)
                                <div class="flex gap-4 py-3"><dt class="w-36 shrink-0 font-medium text-ink">Màu sắc</dt><dd class="text-ink-muted whitespace-pre-line">{{ $project->colors }}</dd></div>
                            @endif
                        </dl>

                        @if ($project->description)
                            <div class="prose prose-neutral mt-8 max-w-none prose-headings:font-serif prose-headings:font-light prose-p:text-ink-muted">
                                {!! $project->description !!}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Lightbox --}}
        <div x-cloak x-show="lightbox" x-transition.opacity
             @click="lightbox = false" @keydown.escape.window="lightbox = false"
             class="fixed inset-0 z-[60] flex items-center justify-center bg-ink/95 p-6">
            <img :src="active" class="max-h-[90vh] max-w-full object-contain" alt="">
        </div>
    </div>

    {{-- Dự án liên quan --}}
    @if ($related->isNotEmpty())
        <section class="border-t border-line bg-cream-deep py-20">
            <div class="mx-auto max-w-7xl px-6 lg:px-10">
                <h2 class="mb-12 text-center font-serif text-3xl font-light">Dự án khác</h2>
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-3">
                    @foreach ($related as $item)
                        <a href="{{ route('projects.show', $item) }}" class="group block">
                            <div class="aspect-[3/4] overflow-hidden bg-ink">
                                <img src="{{ asset('storage/' . $item->grid_image) }}" alt="{{ $item->title }}" loading="lazy"
                                     class="h-full w-full object-cover transition-transform duration-1000 ease-luxe group-hover:scale-105">
                            </div>
                            <h3 class="mt-4 font-serif text-xl font-light text-ink">{{ $item->title }}</h3>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection
