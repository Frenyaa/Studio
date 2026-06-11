{{-- QUY TRÌNH LÀM VIỆC: số lớn 01, 02, 03 làm điểm nhấn --}}
@if ($workflowSteps->isNotEmpty())
<section id="workflow" class="bg-ink-soft py-24 text-cream lg:py-32">
    <div class="mx-auto max-w-7xl px-6 lg:px-10">
        <div class="reveal mb-16 text-center">
            <p class="eyebrow">Quy trình</p>
            <h2 class="mt-4 font-serif text-4xl font-light tracking-wide lg:text-5xl">Quy Trình Đặt Hàng</h2>
            <div class="mx-auto mt-6 h-px w-16 bg-accent/70"></div>
        </div>

        <div class="grid gap-12 md:grid-cols-2 lg:grid-cols-4">
            @foreach ($workflowSteps as $index => $step)
                <div class="relative reveal reveal-d{{ ($index % 4) + 1 }}">
                    <div class="font-serif text-7xl font-extralight leading-none text-cream/25">
                        {{ $step->number ?? str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                    </div>
                    <h3 class="mt-6 font-serif text-2xl font-light">{{ $step->title }}</h3>
                    @if ($step->description)
                        <p class="mt-3 text-sm leading-relaxed text-cream/60">{{ $step->description }}</p>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif
