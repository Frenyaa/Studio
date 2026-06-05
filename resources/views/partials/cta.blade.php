{{-- DẢI CTA TƯ VẤN: ảnh nền toàn màn hình + tiêu đề + nút (phong cách BoConcept) --}}
@php $ctaImage = $ctaImage ?? 'placeholders/project-5.jpg'; @endphp
<section class="relative overflow-hidden">
    {{-- Ảnh nền cố định tạo hiệu ứng chiều sâu --}}
    <div
        class="absolute inset-0 bg-cover bg-center bg-fixed"
        style="background-image:url('{{ asset('storage/' . $ctaImage) }}')"
    ></div>
    <div class="absolute inset-0 bg-ink/60"></div>

    <div class="reveal relative z-10 mx-auto flex max-w-3xl flex-col items-center px-6 py-28 text-center text-cream lg:py-40">
        <p class="text-xs font-medium uppercase tracking-luxe text-cream/60">Bắt đầu hành trình</p>
        <h2 class="mt-5 font-serif text-4xl font-light leading-tight tracking-wide lg:text-5xl">
            Bạn còn phân vân với không gian của mình?
        </h2>
        <p class="mt-6 max-w-xl leading-relaxed text-cream/75">
            Để đội ngũ {{ config('app.name') }} đồng hành cùng bạn — từ ý tưởng đến thi công hoàn thiện,
            kiến tạo tổ ấm đúng gu và đẳng cấp của bạn.
        </p>
        <a href="#contact" class="btn-line mt-10 border-cream/70 text-cream hover:bg-cream hover:text-ink">
            Nhận tư vấn miễn phí
            <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25 21 12m0 0-3.75 3.75M21 12H3"/></svg>
        </a>
    </div>
</section>
