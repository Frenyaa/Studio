{{-- FORM ĐĂNG KÝ TƯ VẤN (trang /lien-he): input gạch chân, gửi AJAX không reload --}}
@php
    $cs = $settings ?? [];
    $consultTitle = ($cs['consult_title'] ?? '') ?: 'Đăng Ký Tư Vấn';
    $consultSubtitle = ($cs['consult_subtitle'] ?? '') ?: 'Để lại thông tin, đội ngũ của chúng tôi sẽ liên hệ tư vấn miễn phí.';
    $consultNeeds = collect(preg_split('/\r\n|\r|\n/', ($cs['consult_needs'] ?? '')))
        ->map(fn ($n) => trim($n))->filter()->values();
    if ($consultNeeds->isEmpty()) {
        $consultNeeds = collect(['Mua sản phẩm có sẵn', 'Đặt làm theo yêu cầu', 'Tư vấn thiết kế', 'Khác']);
    }
@endphp
<section id="contact" class="bg-ink py-24 lg:py-32">
    <div class="mx-auto max-w-3xl px-6 lg:px-10">
        <div class="reveal mb-14 text-center">
            <p class="eyebrow">Liên hệ</p>
            <h2 class="mt-4 font-serif text-4xl font-light tracking-wide lg:text-5xl">{{ $consultTitle }}</h2>
            <p class="mt-5 text-cream/70">{{ $consultSubtitle }}</p>
        </div>

        <form
            x-data="contactForm()"
            @submit.prevent="submit"
            class="space-y-10"
        >
            {{-- Honeypot chống spam (ẩn) --}}
            <input type="text" name="website" x-model="form.website" class="hidden" tabindex="-1" autocomplete="off">

            <div class="grid gap-10 sm:grid-cols-2">
                {{-- Họ và tên --}}
                <div>
                    <input
                        type="text" x-model="form.name" placeholder="Họ và tên *"
                        class="w-full border-0 border-b border-cream/30 bg-transparent px-0 py-3 text-cream placeholder-cream/40 focus:border-cream focus:ring-0"
                    >
                    <p x-show="errors.name" x-text="errors.name" class="mt-2 text-xs text-red-400"></p>
                </div>

                {{-- Số điện thoại --}}
                <div>
                    <input
                        type="tel" x-model="form.phone" placeholder="Số điện thoại *"
                        class="w-full border-0 border-b border-cream/30 bg-transparent px-0 py-3 text-cream placeholder-cream/40 focus:border-cream focus:ring-0"
                    >
                    <p x-show="errors.phone" x-text="errors.phone" class="mt-2 text-xs text-red-400"></p>
                </div>
            </div>

            {{-- Nhu cầu (dropdown) --}}
            <div>
                <select
                    x-model="form.need"
                    class="w-full border-0 border-b border-cream/30 bg-transparent px-0 py-3 text-cream focus:border-cream focus:ring-0 [&>option]:bg-ink [&>option]:text-cream"
                >
                    <option value="">Nhu cầu của bạn</option>
                    @foreach ($consultNeeds as $need)
                        <option value="{{ $need }}">{{ $need }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Lời nhắn --}}
            <div>
                <textarea
                    x-model="form.message" rows="2" placeholder="Lời nhắn"
                    class="w-full resize-none border-0 border-b border-cream/30 bg-transparent px-0 py-3 text-cream placeholder-cream/40 focus:border-cream focus:ring-0"
                ></textarea>
            </div>

            {{-- Nút GỬI to, đen tuyền --}}
            <div class="pt-4 text-center">
                <button
                    type="submit"
                    :disabled="loading"
                    class="w-full bg-accent px-12 py-5 text-sm font-medium uppercase tracking-luxe text-ink transition-opacity duration-300 hover:opacity-90 disabled:opacity-50 sm:w-auto"
                >
                    <span x-show="!loading">Gửi</span>
                    <span x-show="loading" x-cloak>Đang gửi...</span>
                </button>
            </div>

            {{-- Thông báo thành công --}}
            <p
                x-show="success" x-cloak x-transition
                x-text="successMessage"
                class="text-center text-sm font-medium text-emerald-400"
            ></p>
        </form>
    </div>
</section>

@push('scripts')
<script>
function contactForm() {
    return {
        loading: false,
        success: false,
        successMessage: '',
        errors: {},
        form: { name: '', phone: '', email: '', need: '', message: '', website: '' },
        async submit() {
            this.loading = true;
            this.errors = {};
            this.success = false;

            try {
                const res = await fetch('{{ route('leads.store') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: JSON.stringify(this.form),
                });

                if (res.status === 422) {
                    const data = await res.json();
                    Object.keys(data.errors || {}).forEach(k => this.errors[k] = data.errors[k][0]);
                    return;
                }

                const data = await res.json();
                if (data.success) {
                    this.success = true;
                    this.successMessage = data.message;
                    this.form = { name: '', phone: '', email: '', need: '', message: '', website: '' };
                }
            } catch (e) {
                this.errors.phone = 'Có lỗi xảy ra, vui lòng thử lại.';
            } finally {
                this.loading = false;
            }
        }
    }
}
</script>
@endpush
