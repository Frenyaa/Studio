# STUDIO

Website nội thất cao cấp — phong cách tối giản, sang trọng.
Laravel 11 + Filament 3 (trang quản trị) + Tailwind CSS.

## Cài đặt

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
npm run build
php artisan serve
```

## Truy cập

- Trang chủ: http://localhost:8000
- Quản trị: http://localhost:8000/admin
  - Tài khoản: `admin@studio.vn` — mật khẩu: `password`

## Ghi chú

- Toàn bộ nội dung (sản phẩm, danh mục, banner, bài viết, chính sách, khách đăng ký...) quản lý trong trang Admin.
- Khi đưa lên hosting cần PHP 8.2+, MySQL, trỏ web vào thư mục `public/` và bật HTTPS.
