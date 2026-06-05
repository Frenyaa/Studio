{{-- FOOTER --}}
@php
    $s = $settings ?? [];
    $about = ($s['footer_about'] ?? '') ?: 'Thiết kế & thi công nội thất toàn diện theo phong cách tối giản sang trọng — kiến tạo không gian sống tinh tế, bền vững theo thời gian.';
    $address = ($s['contact_address'] ?? '') ?: 'Vũ Tông Phan, Thanh Xuân, Hà Nội';
    $hotline = ($s['contact_hotline'] ?? '') ?: '0900 000 000';
    $email   = ($s['contact_email'] ?? '') ?: 'hello@studio.vn';
    $socials = array_filter([
        'Facebook' => $s['social_facebook'] ?? '',
        'Youtube'  => $s['social_youtube'] ?? '',
        'Tiktok'   => $s['social_tiktok'] ?? '',
        'Zalo'     => $s['social_zalo'] ?? '',
    ]);
@endphp
<footer class="border-t border-line bg-ink text-cream/80">
    <div class="mx-auto max-w-7xl px-6 py-20 lg:px-10">
        <div class="grid gap-12 lg:grid-cols-5">
            {{-- Thương hiệu --}}
            <div class="lg:col-span-2">
                <span class="font-serif text-3xl font-light tracking-luxe text-cream">{{ strtoupper(config('app.name')) }}</span>
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
            @php
                $icons = [
                    'Facebook' => 'M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z',
                    'Youtube'  => 'M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z',
                    'Tiktok'   => 'M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z',
                    'Zalo'     => 'M12 3C6.477 3 2 6.797 2 11.2c0 2.45 1.36 4.64 3.5 6.1L4.7 21l3.86-1.7c1.07.3 2.22.46 3.44.46 5.523 0 10-3.797 10-8.56C22 6.797 17.523 3 12 3z',
                ];
            @endphp
            <div>
                <h4 class="text-xs font-medium uppercase tracking-luxe text-cream">Kết nối</h4>
                <div class="mt-6 flex flex-wrap gap-4">
                    @forelse ($socials as $name => $url)
                        <a href="{{ $url }}" target="_blank" rel="noopener" aria-label="{{ $name }}"
                           class="flex h-10 w-10 items-center justify-center border border-cream/20 transition-colors hover:border-cream hover:text-cream">
                            @if ($name === 'Zalo')
                                <svg class="h-5 w-5" viewBox="0 0 48 48" fill="currentColor"><text x="24" y="31" text-anchor="middle" font-family="Arial, sans-serif" font-size="18" font-weight="700">Zalo</text></svg>
                            @else
                                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="{{ $icons[$name] ?? '' }}"/></svg>
                            @endif
                        </a>
                    @empty
                        <span class="text-sm text-cream/40">Đang cập nhật</span>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="mt-16 flex flex-col items-center justify-between gap-4 border-t border-cream/10 pt-8 text-xs text-cream/40 sm:flex-row">
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
            <p>Nội Thất Cao Cấp | Tối Giản & Sang Trọng</p>
        </div>
    </div>
</footer>
