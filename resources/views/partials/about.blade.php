{{-- GIỚI THIỆU + KHỐI CHỈ SỐ chạy số tự động --}}
<section id="about" class="bg-cream-deep py-24 lg:py-32">
    <div class="mx-auto max-w-7xl px-6 lg:px-10">
        <div class="grid items-center gap-16 lg:grid-cols-2">
            {{-- Phần chữ giới thiệu --}}
            <div class="reveal">
                <p class="eyebrow">Về {{ config('app.name') }}</p>
                <h2 class="mt-4 font-serif text-3xl font-light leading-snug tracking-wide lg:text-4xl">
                    Sự tỉ mỉ trong từng chi tiết, cam kết duy mỹ trọn vẹn cho không gian sống của bạn.
                </h2>
                <p class="mt-6 max-w-lg leading-relaxed text-ink-muted">
                    Chúng tôi theo đuổi triết lý thiết kế tối giản sang trọng — nơi mỗi đường nét, chất liệu và
                    ánh sáng đều được cân nhắc kỹ lưỡng. Hợp tác cùng những nhà cung ứng vật liệu hàng đầu,
                    chúng tôi mang đến trải nghiệm thiết kế — thi công toàn diện, chỉn chu đến từng milimet.
                </p>
            </div>

            {{-- Khối chỉ số Counter --}}
            @if ($stats->isNotEmpty())
                <div
                    x-data="counters()"
                    x-intersect.once="start()"
                    class="reveal reveal-d2 grid grid-cols-2 gap-x-8 gap-y-12"
                >
                    @foreach ($stats as $i => $stat)
                        <div class="border-l border-line pl-6">
                            <div class="font-serif text-5xl font-light text-ink lg:text-6xl">
                                <span>{{ $stat->prefix }}</span><span x-text="vals[{{ $i }}]">0</span><span>{{ $stat->suffix }}</span>
                            </div>
                            <p class="mt-3 text-xs uppercase tracking-luxe text-ink-muted">{{ $stat->label }}</p>
                        </div>
                    @endforeach
                </div>

                @push('scripts')
                <script>
                function counters() {
                    return {
                        vals: @json($stats->map(fn ($s) => 0)),
                        targets: @json($stats->map->numeric_value),
                        start() {
                            this.targets.forEach((target, i) => {
                                const duration = 1800;
                                const startTime = performance.now();
                                const tick = (now) => {
                                    const p = Math.min((now - startTime) / duration, 1);
                                    // easeOutExpo cho cảm giác tinh tế
                                    const eased = p === 1 ? 1 : 1 - Math.pow(2, -10 * p);
                                    this.vals[i] = Math.round(eased * target);
                                    if (p < 1) requestAnimationFrame(tick);
                                };
                                requestAnimationFrame(tick);
                            });
                        }
                    }
                }
                </script>
                @endpush
            @endif
        </div>
    </div>
</section>
