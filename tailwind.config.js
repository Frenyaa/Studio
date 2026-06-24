import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";
import typography from "@tailwindcss/typography";
import aspectRatio from "@tailwindcss/aspect-ratio";

/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./app/Filament/**/*.php",
    "./vendor/filament/**/*.blade.php",
  ],
  theme: {
    extend: {
      colors: {
        // Bảng màu Minimalism Luxury
        // THEME NÂU VÀNG & XANH LÁ TRẦM
        ink: {
          DEFAULT: "#e0d4b8", // nền chính (nâu vàng trầm)
          soft: "#c8dcd1", // nền section xen kẽ (xanh lá trầm)
          warm: "#d9d3c7", // nền trung gian (olive-sage dịu)
          muted: "#6b5d52", // chữ nhãn nhỏ phụ — xám ấm tối
        },
        cream: {
          DEFAULT: "#3d3530", // chữ chính (nâu tối để nổi bật trên nền sáng)
          deep: "#2a2420", // chữ phụ
        },
        porcelain: "#ffffff",
        line: "#b8a583", // đường viền (nâu tối)
        accent: "#7a8b6f", // màu nhấn xanh ô-liu
        // Màu nâu vàng & xanh nhạc (trầm)
        "warm-beige": "#d2be95", // nâu vàng trầm
        "sage-mint": "#83b89f", // xanh lá trầm
      },
      fontFamily: {
        // Font Serif thanh lịch cho tiêu đề
        serif: [
          '"EB Garamond"',
          '"Playfair Display"',
          ...defaultTheme.fontFamily.serif,
        ],
        // Sans cho nội dung (Be Vietnam Pro — hỗ trợ tiếng Việt tốt)
        sans: ['"Be Vietnam Pro"', '"Inter"', ...defaultTheme.fontFamily.sans],
        // Font riêng cho tên thương hiệu (logo chữ)
        brand: [
          '"EB Garamond"',
          '"Playfair Display"',
          ...defaultTheme.fontFamily.serif,
        ],
      },
      letterSpacing: {
        luxe: "0.22em",
      },
      transitionTimingFunction: {
        luxe: "cubic-bezier(0.22, 1, 0.36, 1)",
      },
      keyframes: {
        "fade-up": {
          "0%": { opacity: "0", transform: "translateY(28px)" },
          "100%": { opacity: "1", transform: "translateY(0)" },
        },
        "slow-zoom": {
          "0%": { transform: "scale(1)" },
          "100%": { transform: "scale(1.08)" },
        },
      },
      animation: {
        "fade-up": "fade-up 1s cubic-bezier(0.22, 1, 0.36, 1) both",
        "slow-zoom": "slow-zoom 12s ease-out forwards",
      },
    },
  },
  plugins: [forms, typography, aspectRatio],
};
