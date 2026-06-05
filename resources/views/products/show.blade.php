@extends('layouts.app')

@section('title', ($product->meta_title ?: $product->name) . ' — ' . config('app.name'))
@section('meta_description', $product->meta_description ?: $product->summary)

@php
    $gallery = collect([$product->cover_image])
        ->merge($product->images->pluck('image'))
        ->filter()
        ->unique()
        ->map(fn ($img) => asset('storage/' . $img))
        ->values();
@endphp

@section('content')
    <div
        x-data="{ active: '{{ $gallery->first() }}', lightbox: false }"
        class="bg-ink pt-28 lg:pt-32"
    >
        <div class="mx-auto max-w-7xl px-6 lg:px-10">
            {{-- Breadcrumb --}}
            <nav class="border-b border-line py-5 text-xs uppercase tracking-luxe text-cream/70">
                <a href="{{ route('home') }}" class="transition-colors hover:text-cream">Trang chủ</a>
                <span class="mx-2">/</span>
                <a href="{{ route('products.index') }}" class="transition-colors hover:text-cream">Sản phẩm</a>
                <span class="mx-2">/</span>
                <span class="text-cream">{{ $product->name }}</span>
            </nav>

            <div class="grid gap-10 py-12 lg:grid-cols-2 lg:gap-16">
                {{-- Gallery --}}
                <div>
                    <div class="group relative overflow-hidden bg-ink-soft" @click="lightbox = true">
                        <div class="aspect-[4/3] w-full cursor-zoom-in overflow-hidden">
                            <img :src="active" alt="{{ $product->name }}" class="h-full w-full object-cover">
                        </div>
                        <span class="absolute bottom-4 right-4 flex h-10 w-10 items-center justify-center bg-ink/70 text-cream">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3.75v4.5m0-4.5h4.5m-4.5 0L9 9M3.75 20.25v-4.5m0 4.5h4.5m-4.5 0L9 15M20.25 3.75h-4.5m4.5 0v4.5m0-4.5L15 9m5.25 11.25h-4.5m4.5 0v-4.5m0 4.5L15 15"/></svg>
                        </span>
                    </div>

                    @if ($gallery->count() > 1)
                        <div class="mt-4 grid grid-cols-5 gap-3">
                            @foreach ($gallery as $img)
                                <button
                                    @click="active = '{{ $img }}'"
                                    :class="active === '{{ $img }}' ? 'ring-2 ring-accent' : 'opacity-70 hover:opacity-100'"
                                    class="aspect-square overflow-hidden bg-ink-soft transition-all duration-300"
                                >
                                    <img src="{{ $img }}" alt="{{ $product->name }}" loading="lazy" class="h-full w-full object-cover">
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>

                {{-- Thông tin --}}
                <div class="lg:py-2">
                    <h1 class="font-serif text-4xl font-light leading-tight tracking-wide text-cream lg:text-5xl">{{ $product->name }}</h1>

                    <p class="mt-4 text-xs uppercase tracking-luxe text-cream/70">
                        SKU: {{ $product->sku ?: strtoupper(Str::limit($product->slug, 20, '')) }}
                    </p>

                    <div class="my-7 h-px w-full bg-line"></div>

                    <a
                        href="{{ route('home') }}#contact"
                        class="flex w-full items-center justify-center gap-3 bg-accent px-8 py-5 text-sm font-medium uppercase tracking-luxe text-ink transition-opacity duration-300 hover:opacity-90"
                    >
                        Gặp nhân viên tư vấn
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25 21 12m0 0-3.75 3.75M21 12H3"/></svg>
                    </a>

                    <div class="mt-10">
                        <h2 class="font-serif text-2xl font-light text-cream">Mô tả</h2>

                        <dl class="mt-6 divide-y divide-line border-y border-line text-sm">
                            @if ($product->category)
                                <div class="flex gap-4 py-3"><dt class="w-36 shrink-0 font-medium text-cream">Loại</dt><dd class="text-cream/70">{{ $product->category->name }}</dd></div>
                            @endif
                            @if ($product->dimensions)
                                <div class="flex gap-4 py-3"><dt class="w-36 shrink-0 font-medium text-cream">Kích thước</dt><dd class="text-cream/70">{{ $product->dimensions }}</dd></div>
                            @endif
                            @if ($product->material)
                                <div class="flex gap-4 py-3"><dt class="w-36 shrink-0 font-medium text-cream">Chất liệu</dt><dd class="text-cream/70 whitespace-pre-line">{{ $product->material }}</dd></div>
                            @endif
                            @if ($product->colors)
                                <div class="flex gap-4 py-3"><dt class="w-36 shrink-0 font-medium text-cream">Màu sắc</dt><dd class="text-cream/70 whitespace-pre-line">{{ $product->colors }}</dd></div>
                            @endif
                        </dl>

                        @if ($product->description)
                            <div class="prose prose-invert mt-8 max-w-none prose-headings:font-serif prose-headings:font-light prose-p:text-cream/70">
                                {!! $product->description !!}
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

    {{-- Sản phẩm liên quan --}}
    @if ($related->isNotEmpty())
        <section class="border-t border-line bg-ink-soft py-20">
            <div class="mx-auto max-w-7xl px-6 lg:px-10">
                <h2 class="mb-12 text-center font-serif text-3xl font-light">Sản phẩm khác</h2>
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-3">
                    @foreach ($related as $item)
                        <a href="{{ route('products.show', $item) }}" class="group block">
                            <div class="aspect-[3/4] overflow-hidden bg-ink">
                                <img src="{{ asset('storage/' . $item->grid_image) }}" alt="{{ $item->name }}" loading="lazy"
                                     class="h-full w-full object-cover transition-transform duration-1000 ease-luxe group-hover:scale-105">
                            </div>
                            <h3 class="mt-4 font-serif text-xl font-light text-cream">{{ $item->name }}</h3>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection
