{{-- KHÁCH HÀNG: slider feedback tối giản (Alpine) --}}
@if ($feedbacks->isNotEmpty())
<section class="bg-ink-soft py-24 lg:py-32">
    <div
        x-data="feedbackSlider({{ $feedbacks->count() }})"
        class="reveal mx-auto max-w-3xl px-6 text-center lg:px-10"
    >
        <p class="eyebrow">Khách hàng nói về chúng tôi</p>
        <div class="mx-auto mt-6 mb-12 h-px w-16 bg-accent/70"></div>

        <div class="relative min-h-[220px]">
            @foreach ($feedbacks as $i => $feedback)
                <figure
                    x-show="active === {{ $i }}"
                    x-transition:enter="transition ease-luxe duration-700"
                    x-transition:enter-start="opacity-0 translate-y-4"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    @if(!$loop->first) x-cloak @endif
                    class="absolute inset-0"
                >
                    <blockquote class="font-serif text-2xl font-light italic leading-relaxed text-cream lg:text-3xl">
                        “{{ $feedback->content }}”
                    </blockquote>
                    <figcaption class="mt-8">
                        <span class="block text-sm font-medium uppercase tracking-luxe text-cream">{{ $feedback->client_name }}</span>
                        @if ($feedback->client_location)
                            <span class="mt-1 block text-xs text-cream/70">{{ $feedback->client_location }}</span>
                        @endif
                    </figcaption>
                </figure>
            @endforeach
        </div>

        {{-- Chấm điều hướng --}}
        <div class="mt-10 flex items-center justify-center gap-3">
            @foreach ($feedbacks as $i => $feedback)
                <button
                    @click="go({{ $i }})"
                    :class="active === {{ $i }} ? 'w-8 bg-accent' : 'w-2 bg-cream/30'"
                    class="h-2 rounded-full transition-all duration-500"
                    aria-label="Feedback {{ $i + 1 }}"
                ></button>
            @endforeach
        </div>
    </div>
</section>

@push('scripts')
<script>
function feedbackSlider(count) {
    return {
        active: 0,
        count: count,
        timer: null,
        init() { this.auto(); },
        auto() {
            this.timer = setInterval(() => { this.active = (this.active + 1) % this.count; }, 6000);
        },
        go(i) {
            this.active = i;
            clearInterval(this.timer);
            this.auto();
        }
    }
}
</script>
@endpush
@endif
