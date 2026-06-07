{{-- FOOTER --}}
@php
    $s = $settings ?? [];
    $about = ($s['footer_about'] ?? '') ?: 'Thiết kế & thi công nội thất toàn diện theo phong cách tối giản sang trọng — kiến tạo không gian sống tinh tế, bền vững theo thời gian.';
    $address = ($s['contact_address'] ?? '') ?: 'Vũ Tông Phan, Thanh Xuân, Hà Nội';
    $hotline = ($s['contact_hotline'] ?? '') ?: '0900 000 000';
    $email   = ($s['contact_email'] ?? '') ?: 'hello@studio.vn';
    $slogan  = ($s['footer_slogan'] ?? '') ?: 'Nội Thất Cao Cấp | Tối Giản & Sang Trọng';
    $brand   = ($s['site_name'] ?? '') ?: config('app.name');
    $logo    = $s['site_logo'] ?? '';
    $copyright = str_replace(['{year}', '{brand}'], [date('Y'), $brand], ($s['footer_copyright'] ?? '') ?: '© {year} {brand}. All rights reserved.');
    $socialItems = json_decode($s['socials'] ?? '', true);
    $socialItems = is_array($socialItems) ? array_filter($socialItems, fn ($i) => !empty($i['url'])) : [];
@endphp
<footer class="border-t border-line bg-ink text-cream/80">
    <div class="mx-auto max-w-7xl px-6 py-20 lg:px-10">
        <div class="grid gap-12 lg:grid-cols-5">
            {{-- Thương hiệu --}}
            <div class="lg:col-span-2">
                @if ($logo)
                    <img src="{{ asset('storage/' . $logo) }}" alt="{{ $brand }}" class="h-10 w-auto">
                @else
                    <span class="font-brand text-3xl font-light tracking-luxe text-cream">{{ strtoupper($brand) }}</span>
                @endif
                <p class="mt-6 max-w-sm text-sm leading-relaxed text-cream/60">{{ $about }}</p>
            </div>

            {{-- Liên hệ --}}
            <div>
                <h4 class="text-xs font-medium uppercase tracking-luxe text-cream">Liên hệ</h4>
                <ul class="mt-6 space-y-3 text-sm text-cream/60">
                    <li>{{ $address }}</li>
                    <li>Hotline: <a href="tel:{{ preg_replace('/[^0-9+]/', '', $hotline) }}" class="transition-colors hover:text-cream">{{ $hotline }}</a></li>
                    <li>Email: <a href="mailto:{{ $email }}" class="transition-colors hover:text-cream">{{ $email }}</a></li>
                </ul>
            </div>

            {{-- Chính sách --}}
            @if (!empty($footerPages) && $footerPages->isNotEmpty())
                <div>
                    <h4 class="text-xs font-medium uppercase tracking-luxe text-cream">Chính sách</h4>
                    <ul class="mt-6 space-y-3 text-sm text-cream/60">
                        @foreach ($footerPages as $fp)
                            <li><a href="{{ route('pages.show', $fp->slug) }}" class="transition-colors hover:text-cream">{{ $fp->title }}</a></li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Mạng xã hội / Kết nối --}}
            <div>
                <h4 class="text-xs font-medium uppercase tracking-luxe text-cream">Kết nối</h4>
                <div class="mt-6 flex flex-wrap gap-4">
                    @forelse ($socialItems as $item)
                        @php
                            $plat = $item['platform'] ?? '';
                            $path = \App\Support\SocialPlatforms::icon($plat);
                            $name = \App\Support\SocialPlatforms::label($plat);
                        @endphp
                        <a href="{{ $item['url'] }}" target="_blank" rel="noopener" aria-label="{{ $name }}"
                           class="flex h-10 w-10 items-center justify-center border border-cream/20 transition-colors hover:border-cream hover:text-cream">
                            @if ($path)
                                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="{{ $path }}"/></svg>
                            @else
                                <span class="text-[10px] font-semibold uppercase">{{ $name }}</span>
                            @endif
                        </a>
                    @empty
                        <span class="text-sm text-cream/40">Đang cập nhật</span>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="mt-16 flex flex-col items-center justify-between gap-4 border-t border-cream/10 pt-8 text-xs text-cream/40 sm:flex-row">
            <p>{{ $copyright }}</p>
            <p>{{ $slogan }}</p>
        </div>
    </div>
</footer>

