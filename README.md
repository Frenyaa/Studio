# STUDIO — Portfolio & Dịch vụ Thiết kế Nội thất

Website Portfolio nội thất phong cách **Minimalism Luxury** (tối giản sang trọng)

- **Frontend (public):** Laravel 11 + Blade + Tailwind CSS + Alpine.js
- **Admin Dashboard:** Filament v3
- **Tối ưu:** cache trang chủ, lazy-load video/ảnh, truy vấn gọn, responsive Desktop → Mobile

---

## 1. Yêu cầu môi trường

| Phần mềm | Phiên bản tối thiểu                                                                           |
| -------- | --------------------------------------------------------------------------------------------- |
| PHP      | 8.2+ (bật extension: `mbstring`, `gd` hoặc `imagick`, `pdo_mysql`, `fileinfo`, `zip`, `curl`) |
| Composer | 2.x                                                                                           |
| Node.js  | 18+ và npm                                                                                    |
| MySQL    | 8.0+ (hoặc MariaDB 10.6+, hoặc SQLite)                                                        |

> ⚠️ Máy hiện tại **chưa cài** PHP/Composer/Node. Hãy cài trước (gợi ý: [Laravel Herd](https://herd.laravel.com/windows) cho Windows — đã gồm sẵn PHP + Composer + Nginx).

---

## 2. Cài đặt lần đầu

Mở terminal tại thư mục dự án và chạy lần lượt:

```bash
# 1. Cài thư viện PHP (Laravel + Filament + spatie image-optimizer)
composer install

# 2. Cài thư viện frontend (Tailwind, Alpine, Vite)
npm install

# 3. Tạo file .env và app key
copy .env.example .env        # Windows (PowerShell: Copy-Item .env.example .env)
php artisan key:generate

# 4. Cấu hình DB trong .env (DB_DATABASE, DB_USERNAME, DB_PASSWORD), tạo database rỗng tên "studio"

# 5. Chạy migration + dữ liệu mẫu
php artisan migrate --seed

# 6. Tạo symlink để hiển thị ảnh/video đã upload
php artisan storage:link
```

### Build / chạy giao diện

```bash
# Chế độ phát triển (hot reload)
npm run dev

# Mở thêm 1 terminal nữa để chạy server Laravel
php artisan serve
```

Hoặc build cho production:

```bash
npm run build
```

---

## 3. Truy cập

|                      | URL                         | Tài khoản                          |
| -------------------- | --------------------------- | ---------------------------------- |
| **Trang chủ**        | http://localhost:8000       | —                                  |
| **Danh sách dự án**  | http://localhost:8000/du-an | —                                  |
| **Admin (Filament)** | http://localhost:8000/admin | `admin@studio.vn` / `password` |

> Đổi mật khẩu admin ngay sau lần đăng nhập đầu, hoặc tạo user mới bằng `php artisan make:filament-user`.

---

## 4. Cấu trúc dự án

```
app/
├─ Filament/
│  ├─ Resources/            # 8 Resource quản trị (Form + Table)
│  │  ├─ HeroSlideResource         → Video nền + slogan trang chủ
│  │  ├─ ProjectResource           → Dự án (cốt lõi) + RelationManager thư viện ảnh
│  │  ├─ ProjectCategoryResource   → Danh mục: Căn hộ/Biệt thự/Nhà phố/Thương mại
│  │  ├─ ServiceResource           → Dịch vụ (kéo thả sắp xếp)
│  │  ├─ WorkflowStepResource      → Quy trình 01→04 (kéo thả)
│  │  ├─ ClientFeedbackResource    → Feedback khách hàng
│  │  ├─ PartnerResource           → Đối tác (logo grayscale)
│  │  ├─ SiteStatResource          → Chỉ số: 10+ năm, 30/63 tỉnh...
│  │  └─ LeadResource              → Khách đăng ký + trạng thái xử lý
│  └─ Widgets/LeadStatsWidget.php  # Thống kê nhanh trên Dashboard
├─ Http/Controllers/        # HomeController, ProjectController, LeadController
├─ Http/Requests/           # StoreLeadRequest (validation + honeypot)
├─ Models/                  # 10 model Eloquent
└─ Providers/               # AppServiceProvider (auto-clear cache), AdminPanelProvider

database/migrations/        # Toàn bộ bảng dữ liệu
database/seeders/           # Dữ liệu mẫu (Brave House, Teasu House, Metropolis...)

resources/
├─ css/app.css              # Tailwind + tinh chỉnh
├─ js/app.js                # Alpine.js + plugin intersect
└─ views/
   ├─ layouts/app.blade.php
   ├─ home.blade.php
   ├─ projects/{index,show}.blade.php
   └─ partials/             # hero, portfolio, about, services, workflow, partners, feedback, contact, footer, nav

routes/web.php              # /, /du-an, /du-an/{slug}, POST /lien-he
```

---

## 5. Bảng dữ liệu (Migrations)

| Bảng                 | Mô tả                                                      |
| -------------------- | ---------------------------------------------------------- |
| `hero_slides`        | Video nền (file/url) + poster + slogan + CTA               |
| `project_categories` | Danh mục dự án                                             |
| `projects`           | Dự án: tên, slug, ảnh cover/thumbnail, mô tả, SEO, nổi bật |
| `project_images`     | Thư viện ảnh chi tiết (HasMany → projects)                 |
| `services`           | Dịch vụ                                                    |
| `workflow_steps`     | Bước quy trình (có `sort_order` kéo thả)                   |
| `client_feedback`    | Đánh giá khách hàng                                        |
| `partners`           | Logo đối tác                                               |
| `site_stats`         | Chỉ số chạy số (Counter)                                   |
| `leads`              | Khách đăng ký tư vấn + `status` (new/contacting/won/lost)  |

---

## 6. Tính năng giao diện đã triển khai

- **Hero:** video nền toàn màn hình, `muted/loop/autoplay/playsinline`, **lazy-load** (chỉ gán `src` sau khi tải trang), logo phóng to **mờ dần khi cuộn**, CTA viền mảnh cuộn mượt.
- **Portfolio Grid:** lưới khổ lớn, hover **zoom 1.1x** + hiện tên dự án trượt lên.
- **Workflow:** số lớn 01–04 làm điểm nhấn, nền tối tương phản.
- **Counter chỉ số:** chạy số khi cuộn tới (`x-intersect`, easeOutExpo).
- **Đối tác:** logo **grayscale**, sáng màu khi hover.
- **Feedback:** slider tự chạy + chấm điều hướng (Alpine).
- **Form tư vấn:** input **gạch chân** (underline), dropdown nhu cầu, gửi **AJAX không reload** + validation realtime + honeypot chống spam + throttle 10 req/phút.
- **Footer:** thông tin công ty, địa chỉ Vũ Tông Phan – Thanh Xuân – Hà Nội, hotline, email, icon Facebook/Youtube/Tiktok.

---

## 7. Tối ưu hiệu năng

- Trang chủ gói toàn bộ truy vấn vào **1 cache** (`homepage_data`, 10 phút), tự xoá khi admin lưu/xoá nội dung (xem `AppServiceProvider`).
- Ảnh dùng `loading="lazy"`; dự án có cột `thumbnail` riêng để lưới tải nhẹ.
- (Khuyến nghị) Bật nén ảnh tự động: cài binary cho `spatie/laravel-image-optimizer`
  (`jpegoptim`, `optipng`, `pngquant`, `gifsicle`, `svgo`, `cwebp`) rồi cấu hình hook upload, hoặc dùng `spatie/laravel-medialibrary` cho conversions.

---

## 8. Ảnh placeholder

Seeder tham chiếu ảnh tại `storage/app/public/placeholders/` (project-1..6.jpg, partner-1..6.png).
Bạn có thể:

- Bỏ qua và **upload ảnh thật trong Admin** (khuyến nghị), hoặc
- Thả ảnh mẫu vào `storage/app/public/placeholders/` đúng tên để xem ngay.

---

## 9. Lệnh hữu ích

```bash
php artisan make:filament-user        # Tạo thêm tài khoản admin
php artisan optimize                   # Cache config/route cho production
php artisan optimize:clear             # Xoá toàn bộ cache
php artisan migrate:fresh --seed       # Reset DB + seed lại (⚠ mất dữ liệu)
```
