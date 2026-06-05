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
                // THEME TỐI (than chì trung tính): ink = nền tối, cream = chữ sáng
                ink: {
                    DEFAULT: '#16181a', // nền chính (than chì)
                    soft: '#1e2124',    // nền section xen kẽ / card
                    muted: '#6f7378',
                },
                cream: {
                    DEFAULT: '#ece8e1', // chữ sáng (off-white ấm)
                    deep: '#cfc9bd',
                },
                porcelain: '#ffffff',
                line: '#2b2e31', // đường viền mảnh trên nền tối
                accent: '#c2a679', // màu nhấn champagne/gold
            },
            fontFamily: {
                // Font Serif thanh lịch cho tiêu đề
                serif: ['"Cormorant Garamond"', '"Playfair Display"', ...defaultTheme.fontFamily.serif],
                // Sans tinh tế cho nội dung
                sans: ['"Jost"', '"Inter"', ...defaultTheme.fontFamily.sans],
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
