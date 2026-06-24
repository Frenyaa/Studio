{{-- SẢN PHẨM NỔI BẬT --}}
@if (isset($featuredProducts) && $featuredProducts->isNotEmpty())
<section id="products" class="bg-gradient-to-b from-ink-soft to-ink py-8 lg:py-12">
    <div class="mx-auto max-w-7xl px-6 lg:px-10">
        <div class="reveal mb-6 text-center">
            <p class="eyebrow">Bộ sưu tập</p>
            <h2 class="mt-3 font-serif text-4xl font-light tracking-wide lg:text-5xl">Sản Phẩm Nổi Bật</h2>
            <div class="mx-auto mt-4 h-px w-16 bg-accent/70"></div>
        </div>

        <div class="grid grid-cols-1 gap-x-6 gap-y-2 sm:grid-cols-2 lg:grid-cols-2 lg:auto-rows-fr">
            @foreach ($featuredProducts as $product)
                <a href="{{ route('products.show', $product) }}" class="group reveal reveal-d{{ ($loop->index % 3) + 1 }} flex flex-col h-full {{ $loop->first ? 'row-span-2' : '' }}">
                    <div class="relative overflow-hidden bg-ink {{ $loop->first ? '' : 'flex-1' }}">
                        <div class="{{ $loop->first ? 'aspect-[3/4]' : 'aspect-[3/4]' }} w-full overflow-hidden">
                            <img src="{{ asset('storage/' . $product->grid_image) }}" alt="{{ $product->name }}" loading="lazy"
                                 class="h-full w-full object-cover transition-transform duration-[1400ms] ease-luxe group-hover:scale-105">
                        </div>
                        <div class="absolute inset-0 bg-black/0 transition-colors duration-500 group-hover:bg-black/25"></div>
                    </div>

                    <div class="pt-3">
                        <div class="flex items-baseline justify-between">
                            <div>
                                <h3 class="font-serif {{ $loop->first ? 'text-2xl' : 'text-sm' }} font-light text-cream">{{ $product->name }}</h3>
                                @if ($product->sku)
                                    <p class="mt-1 text-xs uppercase tracking-luxe text-cream/60">SKU: {{ $product->sku }}</p>
                                @endif
                            </div>
                            @if ($product->category)
                                <span class="text-[11px] uppercase tracking-luxe text-cream/60">{{ $product->category->name }}</span>
                            @endif
                        </div>

                        @if ($product->summary)
                            <p class="mt-3 border-t border-line pt-4 text-sm leading-relaxed text-cream line-clamp-2 transition-colors duration-500 group-hover:border-accent/40">
                                {{ $product->summary }}
                            </p>
                        @endif
                    </div>
                </a>
            @endforeach
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
