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
                ink: {
                    DEFAULT: '#1a1a1a', // Đen/than cho chữ
                    soft: '#2b2b2b',
                    muted: '#6b6b6b',
                },
                cream: {
                    DEFAULT: '#f6f3ee', // Kem / off-white nền
                    deep: '#ece7df',
                },
                porcelain: '#ffffff',
                line: '#e3ddd3', // đường viền mảnh
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
