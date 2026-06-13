{{-- ĐỐI TÁC: hàng logo grayscale, sáng màu khi hover --}}
@if ($partners->isNotEmpty())
<section class="border-y border-line bg-ink-soft py-16" id="partners">
    <div class="reveal mx-auto max-w-7xl px-6 lg:px-10">
        <p class="mb-10 text-center text-xs font-medium uppercase tracking-luxe text-cream/70">
            Đối tác & Thương hiệu đồng hành
        </p>
        <div class="flex flex-wrap items-center justify-center gap-x-14 gap-y-10">
            @foreach ($partners as $partner)
                <a
                    @if($partner->website) href="{{ $partner->website }}" target="_blank" rel="noopener" @endif
                    class="block"
                >
                    <img
                        src="{{ asset('storage/' . $partner->logo) }}"
                        alt="{{ $partner->name }}"
                        loading="lazy"
                        class="h-8 w-auto opacity-50 brightness-0 transition-all duration-500 hover:opacity-100 lg:h-10"
                    >
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif
