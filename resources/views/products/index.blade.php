@extends('layouts.app')

@section('title', 'Sản phẩm — ' . config('app.name'))

@section('content')
    <section class="bg-ink pt-32 pb-20 lg:pt-40">
        <div class="mx-auto max-w-7xl px-6 lg:px-10">
            <div class="mb-12 text-center">
                <p class="eyebrow">Bộ sưu tập</p>
                <h1 class="mt-4 font-serif text-4xl font-light tracking-wide lg:text-6xl">Sản Phẩm Nội Thất</h1>
            </div>

            {{-- Bộ lọc loại sản phẩm --}}
            <div class="mb-14 flex flex-wrap items-center justify-center gap-x-8 gap-y-3 text-xs font-medium uppercase tracking-luxe">
                <a href="{{ route('products.index') }}"
                   class="border-b-2 pb-1 transition-colors {{ ! request('category') ? 'border-accent text-cream' : 'border-transparent text-cream/60 hover:text-cream' }}">
                    Tất cả
                </a>
                @foreach ($categories as $category)
                    <a href="{{ route('products.index', ['category' => $category->slug]) }}"
                       class="border-b-2 pb-1 transition-colors {{ request('category') === $category->slug ? 'border-accent text-cream' : 'border-transparent text-cream/60 hover:text-cream' }}">
                        {{ $category->name }}
                    </a>
                @endforeach
            </div>

            @if ($products->isEmpty())
                <p class="text-center text-cream/70">Chưa có sản phẩm nào.</p>
            @else
                <div class="grid grid-cols-1 gap-x-6 gap-y-12 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($products as $product)
                        <a href="{{ route('products.show', $product) }}" class="group block">
                            <div class="relative overflow-hidden bg-ink-soft">
                                <div class="aspect-[3/4] w-full overflow-hidden">
                                    <img src="{{ asset('storage/' . $product->grid_image) }}" alt="{{ $product->name }}" loading="lazy"
                                         class="h-full w-full object-cover transition-transform duration-[1400ms] ease-luxe group-hover:scale-105">
                                </div>
                                <div class="absolute inset-0 bg-ink/0 transition-colors duration-500 group-hover:bg-ink/15"></div>
                            </div>

                            <div class="mt-5 flex items-baseline justify-between">
                                <div>
                                    <h3 class="font-serif text-2xl font-light text-cream">{{ $product->name }}</h3>
                                    @if ($product->sku)
                                        <p class="mt-1 text-xs uppercase tracking-luxe text-cream/60">SKU: {{ $product->sku }}</p>
                                    @endif
                                </div>
                                @if ($product->category)
                                    <span class="text-[11px] uppercase tracking-luxe text-cream/60">{{ $product->category->name }}</span>
                                @endif
                            </div>

                            @if ($product->summary)
                                <p class="mt-3 border-t border-line pt-4 text-sm leading-relaxed text-cream/70 line-clamp-2 transition-colors duration-500 group-hover:border-accent/40">
                                    {{ $product->summary }}
                                </p>
                            @endif
                        </a>
                    @endforeach
                </div>

                <div class="mt-16">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </section>
@endsection
