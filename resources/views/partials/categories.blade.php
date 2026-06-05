{{-- KHÁM PHÁ THEO LOẠI HÌNH: băng chuyền ngang (phong cách "What are you looking for?") --}}
@if ($categories->isNotEmpty())
<section id="categories" class="bg-ink py-24 lg:py-32" x-data="catSlider()">
    <div class="mx-auto max-w-7xl px-6 lg:px-10">
        {{-- Tiêu đề + điều hướng --}}
        <div class="reveal mb-12 flex items-end justify-between gap-6">
            <div>
                <p class="eyebrow">Danh mục sản phẩm</p>
                <h2 class="mt-4 font-serif text-4xl font-light tracking-wide lg:text-5xl">Bạn đang tìm gì?</h2>
            </div>
            <div class="hidden shrink-0 gap-3 sm:flex">
                <button @click="scrollBy(-1)" aria-label="Trước"
                    class="flex h-12 w-12 items-center justify-center border border-cream/30 transition-colors duration-300 hover:bg-cream hover:text-ink">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5"/></svg>
                </button>
                <button @click="scrollBy(1)" aria-label="Sau"
                    class="flex h-12 w-12 items-center justify-center border border-cream/30 transition-colors duration-300 hover:bg-cream hover:text-ink">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5"/></svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Track cuộn ngang (tràn lề phải để gợi ý còn nội dung) --}}
    <div
        x-ref="track"
        class="flex snap-x snap-mandatory gap-5 overflow-x-auto scroll-smooth px-6 pb-4 lg:px-10 cat-scroll"
    >
        @foreach ($categories as $category)
            <a
                href="{{ route('products.index', ['category' => $category->slug]) }}"
                class="group reveal w-[78%] shrink-0 snap-start sm:w-[44%] lg:w-[30%] xl:w-[23%]"
            >
                <div class="relative overflow-hidden bg-ink">
                    <div class="aspect-[3/4] w-full overflow-hidden">
                        @if ($category->cover_image)
                            <img src="{{ asset('storage/' . $category->cover_image) }}" alt="{{ $category->name }}" loading="lazy"
                                 class="h-full w-full object-cover transition-transform duration-[1400ms] ease-luxe group-hover:scale-105">
                        @else
                            <div class="flex h-full w-full items-center justify-center bg-ink-soft text-cream/70">
                                <span class="font-serif text-2xl">{{ $category->name }}</span>
                            </div>
                        @endif
                    </div>
                    <div class="absolute inset-0 bg-ink/0 transition-colors duration-500 group-hover:bg-ink/15"></div>
                </div>
                <div class="mt-4 flex items-center justify-between">
                    <h3 class="font-serif text-2xl font-light text-cream">{{ $category->name }}</h3>
                    <svg class="h-5 w-5 -translate-x-2 text-cream opacity-0 transition-all duration-500 ease-luxe group-hover:translate-x-0 group-hover:opacity-100" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25 21 12m0 0-3.75 3.75M21 12H3"/></svg>
                </div>
            </a>
        @endforeach
    </div>
</section>

@push('scripts')
<script>
function catSlider() {
    return {
        scrollBy(dir) {
            const track = this.$refs.track;
            const amount = Math.round(track.clientWidth * 0.7) * dir;
            track.scrollBy({ left: amount, behavior: 'smooth' });
        }
    }
}
</script>
@endpush
@endif
