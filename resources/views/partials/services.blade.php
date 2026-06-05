{{-- DỊCH VỤ --}}
@if ($services->isNotEmpty())
<section id="services" class="bg-cream-deep py-24 lg:py-32">
    <div class="mx-auto max-w-7xl px-6 lg:px-10">
        <div class="reveal mb-16 text-center">
            <p class="eyebrow">Dịch vụ</p>
            <h2 class="mt-4 font-serif text-4xl font-light tracking-wide lg:text-5xl">Chúng Tôi Mang Đến</h2>
            <div class="mx-auto mt-6 h-px w-16 bg-ink/30"></div>
        </div>

        <div class="grid gap-px overflow-hidden rounded-sm bg-line sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($services as $service)
                <div class="group reveal reveal-d{{ ($loop->index % 3) + 1 }} bg-cream p-10 transition-colors duration-500 hover:bg-porcelain">
                    @if ($service->image)
                        <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->title }}" loading="lazy" class="mb-6 h-14 w-14 object-contain">
                    @elseif ($service->icon)
                        <x-dynamic-component :component="$service->icon" class="mb-6 h-10 w-10 text-ink" />
                    @endif

                    <h3 class="font-serif text-2xl font-light">{{ $service->title }}</h3>
                    @if ($service->summary)
                        <p class="mt-4 text-sm leading-relaxed text-ink-muted">{{ $service->summary }}</p>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif
