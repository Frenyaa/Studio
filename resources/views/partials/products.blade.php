{{-- SẢN PHẨM NỔI BẬT --}}
@if (isset($featuredProducts) && $featuredProducts->isNotEmpty())
<section id="products" class="bg-gradient-to-b from-ink-soft to-ink py-8 lg:py-12">
    <div class="mx-auto max-w-[85rem] px-6 lg:px-10">
        <div class="reveal mb-6 text-center">
            <p class="eyebrow">Bộ sưu tập</p>
            <h2 class="mt-3 font-serif text-4xl font-light tracking-wide lg:text-5xl">Sản Phẩm Nổi Bật</h2>
            <div class="mx-auto mt-4 h-px w-16 bg-accent/70"></div>
        </div>

        <div class="grid grid-cols-1 gap-8 lg:grid-cols-2 lg:items-stretch">
            {{-- Cột trái: 1 Item To (50%) --}}
            @if(isset($featuredProducts[0]))
                @php $firstProduct = $featuredProducts[0]; @endphp
                <a href="{{ route('products.show', $firstProduct) }}" class="group reveal flex flex-col h-full bg-ink-soft/10 p-6 border border-line/20 rounded-sm hover:border-accent/40 transition-colors duration-500">
                    <div class="relative overflow-hidden bg-ink flex-1 min-h-[380px] lg:min-h-0 rounded-sm">
                        <img src="{{ Str::startsWith($firstProduct->grid_image, 'http') ? $firstProduct->grid_image : asset('storage/' . $firstProduct->grid_image) }}" alt="{{ $firstProduct->name }}" loading="lazy"
                             class="absolute inset-0 h-full w-full object-cover transition-transform duration-[1400ms] ease-luxe group-hover:scale-105">
                        <div class="absolute inset-0 bg-black/0 transition-colors duration-500 group-hover:bg-black/25"></div>
                    </div>

                    <div class="pt-5 flex flex-col justify-between">
                        <div class="flex items-baseline justify-between">
                            <div>
                                <h3 class="font-serif text-2xl font-light text-cream group-hover:text-accent transition-colors duration-300">{{ $firstProduct->name }}</h3>
                                @if ($firstProduct->sku)
                                    <p class="mt-1 text-[11px] uppercase tracking-luxe text-cream/50">SKU: {{ $firstProduct->sku }}</p>
                                @endif
                            </div>
                            @if ($firstProduct->category)
                                <span class="text-[11px] uppercase tracking-luxe text-cream/50">{{ $firstProduct->category->name }}</span>
                            @endif
                        </div>

                        @if ($firstProduct->summary)
                            <p class="mt-4 border-t border-line/20 pt-4 text-sm leading-relaxed text-cream/80 line-clamp-2">
                                {{ $firstProduct->summary }}
                            </p>
                        @endif
                    </div>
                </a>
            @endif

            {{-- Cột phải: 2 Items nằm ngang xếp chồng (50%) --}}
            <div class="flex flex-col justify-between gap-6">
                @foreach ($featuredProducts->slice(1, 2) as $product)
                    <a href="{{ route('products.show', $product) }}" class="group reveal flex flex-row gap-6 p-6 bg-ink-soft/10 border border-line/20 rounded-sm h-full lg:h-[calc(50%-12px)] items-stretch hover:border-accent/40 transition-colors duration-500">
                        <div class="relative overflow-hidden bg-ink w-[32%] lg:w-[180px] xl:w-[200px] flex-shrink-0 rounded-sm h-full min-h-[140px] lg:min-h-0">
                            <img src="{{ Str::startsWith($product->grid_image, 'http') ? $product->grid_image : asset('storage/' . $product->grid_image) }}" alt="{{ $product->name }}" loading="lazy"
                                 class="absolute inset-0 h-full w-full object-cover transition-transform duration-[1400ms] ease-luxe group-hover:scale-105">
                            <div class="absolute inset-0 bg-black/0 transition-colors duration-500 group-hover:bg-black/25"></div>
                        </div>

                        <div class="flex-1 flex flex-col justify-between py-1">
                            <div>
                                <div class="flex items-baseline justify-between">
                                    <h3 class="font-serif text-xl font-light text-cream group-hover:text-accent transition-colors duration-300">{{ $product->name }}</h3>
                                    @if ($product->category)
                                        <span class="text-[10px] uppercase tracking-luxe text-cream/50 ml-2 flex-shrink-0">{{ $product->category->name }}</span>
                                    @endif
                                </div>
                                
                                @if ($product->sku)
                                    <p class="mt-1 text-[10px] uppercase tracking-luxe text-cream/50">SKU: {{ $product->sku }}</p>
                                @endif

                                @if ($product->summary)
                                    <p class="mt-3 text-xs leading-relaxed text-cream/70 line-clamp-3">
                                        {{ $product->summary }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

        <div class="reveal mt-16 text-center">
            <a href="{{ route('products.index') }}" class="btn-line border-cream/70 text-cream hover:bg-cream hover:text-ink">
                Xem tất cả sản phẩm
                <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25 21 12m0 0-3.75 3.75M21 12H3"/></svg>
            </a>
        </div>
    </div>
</section>
@endif
