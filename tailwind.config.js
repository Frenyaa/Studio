import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';
import aspectRatio from '@tailwindcss/aspect-ratio';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './app/Filament/**/*.php',
        './vendor/filament/**/*.blade.php',
    ],
    theme: {
        extend: {
            colors: {
                // Bảng màu Minimalism Luxury
                // THEME SÁNG (kem ấm + nhấn xanh ô-liu).
                // Giữ NGUYÊN tên token cũ để khỏi sửa toàn bộ template — chỉ đảo ý nghĩa:
                //   ink   = NỀN sáng (kem)      -> dùng cho bg-ink, bg-ink-soft
                //   cream = CHỮ tối (nâu trầm)  -> dùng cho text-cream, border-cream...
                ink: {
                    DEFAULT: '#f4ecda', // nền chính (nâu vàng / sand ấm rõ)
                    soft: '#e6ecdb',    // nền section xen kẽ (xanh sage nhẹ — để thấy rõ xanh lá)
                    muted: '#8a8073',   // chữ nhãn nhỏ phụ — xám ấm
                },
                cream: {
                    DEFAULT: '#3a352a', // chữ chính (nâu trầm)
                    deep: '#5b5246',    // chữ phụ
                },
                porcelain: '#ffffff',
                line: '#ded2bb', // đường viền mảnh trên nền sáng (ngả nâu vàng)
                accent: '#647a4f', // màu nhấn xanh ô-liu (đậm hơn cho rõ)
            },
            fontFamily: {
                // Font Serif thanh lịch cho tiêu đề
                serif: ['"Cormorant Garamond"', '"Playfair Display"', ...defaultTheme.fontFamily.serif],
                // Sans cho nội dung (Be Vietnam Pro — hỗ trợ tiếng Việt tốt)
                sans: ['"Be Vietnam Pro"', '"Inter"', ...defaultTheme.fontFamily.sans],
                // Font riêng cho tên thương hiệu (logo chữ)
                brand: ['"Cormorant Garamond"', '"Playfair Display"', ...defaultTheme.fontFamily.serif],
            },
            letterSpacing: {
                luxe: '0.22em',
            },
            transitionTimingFunction: {
                luxe: 'cubic-bezier(0.22, 1, 0.36, 1)',
            },
            keyframes: {
                'fade-up': {
                    '0%': { opacity: '0', transform: 'translateY(28px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
                'slow-zoom': {
                    '0%': { transform: 'scale(1)' },
                    '100%': { transform: 'scale(1.08)' },
                },
            },
            animation: {
                'fade-up': 'fade-up 1s cubic-bezier(0.22, 1, 0.36, 1) both',
                'slow-zoom': 'slow-zoom 12s ease-out forwards',
            },
        },
    },
    plugins: [forms, typography, aspectRatio],
};
