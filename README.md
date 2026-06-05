# STUDIO — Website Nội Thất Cao Cấp

Website giới thiệu & bán **nội thất cao cấp** phong cách **Tối giản sang trọng** (Minimalism Luxury): sofa, bàn ghế, giường tủ, thảm, đồ ngoài trời... kèm trang quản trị để tự cập nhật nội dung.

- **Frontend (public):** Laravel 11 + Blade + Tailwind CSS + Alpine.js
- **Admin Dashboard:** Filament v3
- **Tối ưu:** cache trang chủ, lazy-load video/ảnh, truy vấn gọn, responsive Desktop → Mobile
- **Repo:** https://github.com/Frenyaa/Studio

---

## 1. Yêu cầu môi trường

| Phần mềm | Phiên bản tối thiểu |
| -------- | ------------------- |
| PHP      | 8.2+ (extension: `mbstring`, `gd`, `pdo_mysql`, `pdo_sqlite`, `fileinfo`, `zip`, `curl`, `intl`, `openssl`) |
| Composer | 2.x |
| Node.js  | 18+ và npm |
| Database | MySQL 8.0+ / MariaDB 10.6+ **hoặc** SQLite (mặc định cho dev) |

> Gợi ý trên Windows: dùng [Laravel Herd](https://herd.laravel.com/windows) hoặc cài PHP + Composer + Node thủ công và thêm vào PATH.

---

## 2. Cài đặt lần đầu

```bash
# 1. Thư viện PHP (Laravel + Filament)
composer install

# 2. Thư viện frontend (Tailwind, Alpine, Vite)
npm install

# 3. Tạo .env + app key
copy .env.example .env        # PowerShell: Copy-Item .env.example .env
php artisan key:generate

# 4. Cấu hình database trong .env (xem mục dưới)

# 5. Migration + dữ liệu mẫu
php artisan migrate --seed

# 6. Symlink hiển thị ảnh/video upload
php artisan storage:link

# 7. Build giao diện
npm run build      # production
# hoặc: npm run dev (hot reload khi phát triển) + php artisan serve
```

**Cấu hình database:**
- **SQLite (nhanh, dev):** đặt `DB_CONNECTION=sqlite` trong `.env` và tạo file rỗng `database/database.sqlite`.
- **MySQL (production):** đặt `DB_CONNECTION=mysql`, tạo database rỗng tên `studio`, điền `DB_USERNAME` / `DB_PASSWORD`.

---

## 3. Truy cập

| Trang | URL | Tài khoản |
| ----- | --- | --------- |
| **Trang chủ** | http://localhost:8000 | — |
| **Sản phẩm** | http://localhost:8000/du-an | — |
| **Cảm hứng (blog)** | http://localhost:8000/cam-hung | — |
| **Admin (Filament)** | http://localhost:8000/admin | `admin@studio.vn` / `password` |

> ⚠️ Đổi mật khẩu admin trước khi lên production, hoặc tạo user mới: `php artisan make:filament-user`.

---

## 4. Cấu trúc dự án

```
app/
├─ Filament/
│  ├─ Resources/                    # Resource quản trị (Form + Table)
│  │  ├─ HeroSlideResource          → Hero: video nền + poster + slogan + CTA
│  │  ├─ ProjectResource            → Sản phẩm nội thất (cốt lõi) + thư viện ảnh
│  │  │                               Trường: SKU, Kích thước, Chất liệu, Màu sắc
│  │  ├─ ProjectCategoryResource    → Danh mục theo phòng (Phòng khách, bếp, ngủ...)
│  │  ├─ ServiceResource            → Dịch vụ / cam kết (kéo thả sắp xếp)
│  │  ├─ WorkflowStepResource       → Quy trình đặt hàng 01→04 (kéo thả)
│  │  ├─ ClientFeedbackResource     → Feedback khách hàng
│  │  ├─ PartnerResource            → Đối tác (logo grayscale)
│  │  ├─ SiteStatResource           → Chỉ số (Counter chạy số)
│  │  ├─ PostResource               → Bài viết "Cảm hứng" (blog)
│  │  ├─ PageResource               → Trang nội dung & Chính sách
│  │  └─ LeadResource               → Khách đăng ký + trạng thái (CRM mini)
│  └─ Widgets/LeadStatsWidget.php   # Thống kê nhanh trên Dashboard
├─ Http/Controllers/                # Home, Project, Blog, Page, Lead
├─ Http/Requests/                   # StoreLeadRequest (validation + honeypot)
├─ Models/                          # HeroSlide, Project, ProjectImage, ProjectCategory,
│                                     Service, WorkflowStep, ClientFeedback, Partner,
│                                     SiteStat, Lead, Post, Page, User
└─ Providers/                       # AppServiceProvider (auto-clear cache, footer pages),
                                      AdminPanelProvider

database/migrations/                # Toàn bộ bảng
database/seeders/DatabaseSeeder.php # Dữ liệu mẫu (sản phẩm, danh mục, blog, chính sách...)

resources/
├─ css/app.css                      # Tailwind + tinh chỉnh (reveal, scroll-padding...)
├─ js/app.js                        # Alpine.js + intersect + scroll reveal
└─ views/
   ├─ layouts/app.blade.php
   ├─ home.blade.php
   ├─ projects/{index,show}.blade.php   # show = trang chi tiết sản phẩm (gallery + thông số)
   ├─ blog/{index,show}.blade.php
   ├─ pages/show.blade.php
   └─ partials/  # nav, hero, categories, portfolio, spotlight, services, about,
                 # workflow, partners, feedback, insights, cta, contact, footer

routes/web.php  # /, /du-an, /du-an/{slug}, /cam-hung, /cam-hung/{slug},
                # /trang/{slug}, POST /lien-he
```

---

## 5. Bảng dữ liệu

| Bảng | Mô tả |
| ---- | ----- |
| `hero_slides` | Hero: video (file/url) + poster + slogan + CTA |
| `project_categories` | Danh mục theo phòng (Phòng khách, Phòng bếp, Phòng ngủ, Phòng làm việc, Thảm, Ngoài trời) |
| `projects` | Sản phẩm nội thất: tên, slug, **sku, dimensions, material, colors**, ảnh, mô tả, SEO, nổi bật |
| `project_images` | Thư viện ảnh chi tiết (HasMany → projects) |
| `services` | Dịch vụ / cam kết |
| `workflow_steps` | Bước quy trình đặt hàng (kéo thả) |
| `client_feedback` | Đánh giá khách hàng |
| `partners` | Logo đối tác |
| `site_stats` | Chỉ số chạy số |
| `posts` | Bài viết blog (Cảm hứng) |
| `pages` | Trang nội dung tĩnh / chính sách (hiện ở footer) |
| `leads` | Khách đăng ký tư vấn + `status` (new/contacting/won/lost) |

---

## 6. Tính năng nổi bật

- **Hero video nền** toàn màn hình (autoplay/muted/loop, lazy-load, có ảnh poster dự phòng).
- **Băng chuyền danh mục** "Bạn đang tìm gì?" (cuộn ngang, snap, nút điều hướng).
- **Lưới sản phẩm** khổ lớn 3:4, hover zoom, caption editorial + mô tả ngắn.
- **Trang chi tiết sản phẩm** kiểu e-commerce: gallery + thumbnail + lightbox, thông số **SKU · Kích thước · Chất liệu · Màu sắc**, nút "Gặp nhân viên tư vấn" (**không giá / không số lượng**).
- **Sản phẩm nổi bật (spotlight)** dạng 2 cột kể chuyện.
- **Chỉ số Counter** chạy số khi cuộn tới; **scroll-reveal** mượt toàn trang.
- **Đối tác** logo grayscale; **Feedback** slider tự chạy.
- **Blog "Cảm hứng"** (danh sách + chi tiết + bài liên quan).
- **Trang chính sách** quản lý động, tự hiện ở footer.
- **Dải CTA** tư vấn ảnh nền + **Form đăng ký** gửi AJAX (honeypot + throttle).
- **CRM mini:** quản lý khách đăng ký theo pipeline trạng thái + widget thống kê.
- **Menu** đổi màu nhấn (champagne) khi hover; menu mobile nền đặc; header tự đổi theo trang.

---

## 7. Tối ưu hiệu năng

- Trang chủ gói toàn bộ truy vấn vào **1 cache** (`homepage_data`, 10 phút), tự xoá khi admin lưu/xoá nội dung (`AppServiceProvider`).
- Ảnh dùng `loading="lazy"`; sản phẩm có cột `thumbnail` riêng cho lưới.
- (Tuỳ chọn) Bật nén ảnh tự động với `spatie/laravel-image-optimizer` (cần cài binary `jpegoptim`, `optipng`, `pngquant`, `cwebp`...).

---

## 8. Ảnh & video demo

Nằm trong `storage/app/public/`:
- `placeholders/project-1..6.jpg` — ảnh sản phẩm
- `placeholders/post-1..3.jpg` — ảnh blog
- `placeholders/partner-1..6.svg` — logo đối tác
- `placeholders/hero.jpg` — poster hero
- `hero/videos/hero-demo.mp4` — video nền hero

> Thay bằng ảnh/video thật trong **Admin** (Hero, Sản phẩm, Đối tác, Bài viết). Khi deploy, nhớ copy thư mục `storage/app/public` hoặc upload lại qua Admin.

---

## 9. Lệnh hữu ích

```bash
php artisan make:filament-user     # Tạo tài khoản admin mới
php artisan migrate:fresh --seed   # Reset DB + seed lại (⚠ mất dữ liệu hiện có)
php artisan optimize               # Cache config/route (production)
php artisan optimize:clear         # Xoá toàn bộ cache
npm run build                      # Build assets production
```

---

## 10. Ghi chú triển khai (deploy)

- Cần hosting chạy được **Laravel/PHP 8.2+**, có **lưu trữ bền** cho ảnh upload và **database MySQL**.
- Trỏ document root vào thư mục **`public/`**; chạy `php artisan key:generate`, `migrate --seed`, `storage:link`; bật HTTPS.
- Nếu hosting không chạy `composer`/`npm`: repo đã kèm sẵn `vendor`, `node_modules`, `public/build` để tải thẳng lên (chỉ cần tạo `.env`).
