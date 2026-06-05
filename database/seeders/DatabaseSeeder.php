<?php

namespace Database\Seeders;

use App\Models\ClientFeedback;
use App\Models\HeroSlide;
use App\Models\Page;
use App\Models\Partner;
use App\Models\Post;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\ProjectImage;
use App\Models\Service;
use App\Models\SiteStat;
use App\Models\User;
use App\Models\WorkflowStep;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Tài khoản admin Filament
        User::updateOrCreate(
            ['email' => 'admin@studio.vn'],
            ['name' => 'Admin STUDIO', 'password' => Hash::make('password')]
        );

        // Hero
        HeroSlide::updateOrCreate(['id' => 1], [
            'poster_image' => 'placeholders/hero.jpg',
            'slogan' => 'THIẾT KẾ THI CÔNG TOÀN DIỆN CHO NGÔI NHÀ CỦA BẠN',
            'sub_slogan' => 'Minimalism Luxury',
            'cta_label' => 'XEM DỰ ÁN',
            'cta_anchor' => '#portfolio',
            'show_logo_overlay' => true,
            'is_active' => true,
        ]);

        // Danh mục theo phòng / loại nội thất
        $categories = collect([
            ['name' => 'Phòng khách', 'slug' => 'phong-khach'],
            ['name' => 'Phòng bếp', 'slug' => 'phong-bep'],
            ['name' => 'Phòng ngủ', 'slug' => 'phong-ngu'],
            ['name' => 'Phòng làm việc', 'slug' => 'phong-lam-viec'],
            ['name' => 'Thảm nhập khẩu', 'slug' => 'tham-nhap-khau'],
            ['name' => 'Bàn ghế ngoài trời', 'slug' => 'ban-ghe-ngoai-troi'],
        ])->map(fn ($c, $i) => ProjectCategory::updateOrCreate(['slug' => $c['slug']], $c + ['sort_order' => $i, 'is_active' => true]));

        // Sản phẩm nội thất mẫu (ảnh placeholder — admin thay sau)
        $products = [
            [
                'title' => 'Sofa Góc Socco', 'cat' => 'phong-khach', 'img' => 1, 'sku' => 'V1.0',
                'dimensions' => 'D2800 x R1600 (mm)',
                'material' => "Khung gỗ dầu chống cong vênh, mối mọt.\nNệm mousse D40 dày 15cm, độ đàn hồi cao gấp 40% so với mousse thông thường.",
                'colors' => 'Hơn 200 màu vải, da với chất liệu: Bố, Nhung, Nỉ, Da công nghiệp.',
                'summary' => 'Sofa góc bọc nỉ êm ái, khung gỗ dầu bền chắc, tự do phối màu và kích thước theo sở thích.',
                'desc' => '<p>Điều đặc biệt là bạn có thể tự do phối màu và kích thước theo sở thích. Đối với sofa góc, bạn có thể lựa chọn hướng góc theo không gian bố trí.</p><p>Giá bán chưa bao gồm gối trang trí và các đồ trang trí khác.</p>',
            ],
            [
                'title' => 'Bàn Trà Mặt Đá Marble', 'cat' => 'phong-khach', 'img' => 2, 'sku' => 'BT.02',
                'dimensions' => 'D1200 x R600 x C420 (mm)',
                'material' => 'Mặt đá marble tự nhiên, chân gỗ sồi phủ PU.',
                'colors' => 'Trắng vân mây, Đen kim sa, Ghi xi măng.',
                'summary' => 'Bàn trà mặt đá marble sang trọng, chân gỗ sồi vững chãi, điểm nhấn cho phòng khách.',
                'desc' => '<p>Mặt đá marble tự nhiên với vân đá độc bản, mỗi sản phẩm là duy nhất. Bề mặt được xử lý chống thấm, dễ vệ sinh.</p>',
            ],
            [
                'title' => 'Tủ Bếp Acrylic Bóng Gương', 'cat' => 'phong-bep', 'img' => 3, 'sku' => 'TB.03',
                'dimensions' => 'Thiết kế theo không gian thực tế',
                'material' => 'Thùng tủ gỗ MDF lõi xanh chống ẩm, cánh phủ Acrylic bóng gương.',
                'colors' => 'Trắng, Kem, Xám, các tông vân gỗ.',
                'summary' => 'Tủ bếp Acrylic bóng gương hiện đại, chống ẩm, tối ưu lưu trữ cho gian bếp.',
                'desc' => '<p>Bề mặt Acrylic bóng gương sang trọng, chống trầy xước và dễ lau chùi. Phụ kiện ray trượt giảm chấn nhập khẩu.</p>',
            ],
            [
                'title' => 'Giường Ngủ Bọc Nệm', 'cat' => 'phong-ngu', 'img' => 4, 'sku' => 'GN.04',
                'dimensions' => 'D2000 x R1800 (mm)',
                'material' => 'Khung gỗ tự nhiên, đầu giường bọc nệm cao cấp.',
                'colors' => 'Be, Ghi, Nâu tằm, Xanh rêu.',
                'summary' => 'Giường ngủ đầu bọc nệm êm ái, khung gỗ tự nhiên chắc chắn, nhẹ nhàng và thư thái.',
                'desc' => '<p>Đầu giường bọc nệm tựa lưng êm ái, mang lại cảm giác thư giãn. Khung gỗ tự nhiên bền bỉ theo thời gian.</p>',
            ],
            [
                'title' => 'Bàn Làm Việc Gỗ Óc Chó', 'cat' => 'phong-lam-viec', 'img' => 5, 'sku' => 'BLV.05',
                'dimensions' => 'D1400 x R700 x C750 (mm)',
                'material' => 'Gỗ óc chó nguyên khối, phủ dầu lau tự nhiên.',
                'colors' => 'Nâu óc chó tự nhiên.',
                'summary' => 'Bàn làm việc gỗ óc chó nguyên khối, đường nét tinh giản, ấm áp và sang trọng.',
                'desc' => '<p>Gỗ óc chó nhập khẩu với vân gỗ đẹp tự nhiên. Hoàn thiện dầu lau giữ được vẻ mộc và an toàn cho sức khỏe.</p>',
            ],
            [
                'title' => 'Thảm Dệt Nhập Khẩu', 'cat' => 'tham-nhap-khau', 'img' => 6, 'sku' => 'TM.06',
                'dimensions' => '1600 x 2300 (mm)',
                'material' => 'Sợi lông cừu pha viscose, dệt thủ công.',
                'colors' => 'Kem, Ghi sáng, Xám khói.',
                'summary' => 'Thảm dệt thủ công nhập khẩu, sợi mềm mịn, tôn lên sự ấm cúng cho không gian.',
                'desc' => '<p>Thảm được dệt thủ công với chất sợi cao cấp, bề mặt mềm mịn, giữ ấm tốt và bền màu.</p>',
            ],
            [
                'title' => 'Bộ Bàn Ghế Sân Vườn', 'cat' => 'ban-ghe-ngoai-troi', 'img' => 1, 'sku' => 'NT.07',
                'dimensions' => 'Bộ gồm 1 bàn + 4 ghế',
                'material' => 'Khung nhôm đúc sơn tĩnh điện, đan dây nhựa giả mây chịu thời tiết.',
                'colors' => 'Nâu, Xám, Đen.',
                'summary' => 'Bộ bàn ghế ngoài trời chịu thời tiết, khung nhôm bền nhẹ, thư giãn cho sân vườn, ban công.',
                'desc' => '<p>Chất liệu chịu nắng mưa, không gỉ sét, phù hợp sân vườn, ban công, hồ bơi. Đệm ngồi tháo rời dễ vệ sinh.</p>',
            ],
        ];

        foreach ($products as $i => $p) {
            Project::updateOrCreate(['slug' => \Illuminate\Support\Str::slug($p['title'])], [
                'title' => $p['title'],
                'project_category_id' => $categories->firstWhere('slug', $p['cat'])?->id,
                'sku' => $p['sku'],
                'dimensions' => $p['dimensions'],
                'material' => $p['material'],
                'colors' => $p['colors'],
                // Ảnh placeholder; thay bằng ảnh thật trong Admin
                'cover_image' => 'placeholders/project-' . $p['img'] . '.jpg',
                'summary' => $p['summary'],
                'description' => $p['desc'],
                'is_featured' => true,
                'is_published' => true,
                'sort_order' => $i,
            ]);
        }

        // Thư viện ảnh chi tiết cho mỗi dự án (dùng lại ảnh demo)
        foreach (Project::all()->values() as $idx => $project) {
            if ($project->images()->count() === 0) {
                for ($g = 1; $g <= 4; $g++) {
                    $n = (($idx + $g) % 6) + 1;
                    ProjectImage::create([
                        'project_id' => $project->id,
                        'image' => 'placeholders/project-' . $n . '.jpg',
                        'sort_order' => $g,
                    ]);
                }
            }
        }

        // Dịch vụ
        $services = [
            ['title' => 'Thiết kế', 'summary' => 'Concept & bản vẽ 3D chi tiết, định hình phong cách riêng cho không gian.'],
            ['title' => 'Thi công trọn gói', 'summary' => 'Thi công toàn diện, giám sát chặt chẽ, bàn giao đúng tiến độ.'],
            ['title' => 'Cải tạo', 'summary' => 'Làm mới không gian cũ với giải pháp tối ưu công năng và thẩm mỹ.'],
        ];
        foreach ($services as $i => $s) {
            Service::updateOrCreate(['slug' => \Illuminate\Support\Str::slug($s['title'])], $s + ['sort_order' => $i, 'is_active' => true]);
        }

        // Quy trình
        $steps = [
            ['number' => '01', 'title' => 'Khảo sát', 'description' => 'Lắng nghe nhu cầu, đo đạc và phân tích hiện trạng không gian.'],
            ['number' => '02', 'title' => 'Thiết kế 3D', 'description' => 'Xây dựng concept và phối cảnh 3D chân thực để bạn hình dung.'],
            ['number' => '03', 'title' => 'Sản xuất', 'description' => 'Gia công nội thất tại xưởng với vật liệu được kiểm soát chất lượng.'],
            ['number' => '04', 'title' => 'Thi công', 'description' => 'Lắp đặt, hoàn thiện và bàn giao công trình đúng cam kết.'],
        ];
        foreach ($steps as $i => $s) {
            WorkflowStep::updateOrCreate(['title' => $s['title']], $s + ['sort_order' => $i, 'is_active' => true]);
        }

        // Chỉ số
        $stats = [
            ['value' => '10', 'suffix' => '+', 'label' => 'Năm kinh nghiệm'],
            ['value' => '30', 'suffix' => '/63', 'label' => 'Tỉnh thành'],
            ['value' => '80', 'suffix' => '+', 'label' => 'Công trình'],
            ['value' => '30', 'suffix' => '+', 'label' => 'Nhân sự'],
        ];
        foreach ($stats as $i => $s) {
            SiteStat::updateOrCreate(['label' => $s['label']], $s + ['sort_order' => $i, 'is_active' => true]);
        }

        // Đối tác (logo placeholder)
        foreach (['Kohler', 'Dulux', 'Toto', 'Häfele', 'Caesar', 'An Cường'] as $i => $name) {
            Partner::updateOrCreate(['name' => $name], [
                'logo' => 'placeholders/partner-' . ($i + 1) . '.svg',
                'sort_order' => $i,
                'is_active' => true,
            ]);
        }

        // Feedback
        $feedbacks = [
            ['client_name' => 'Anh Kiên', 'client_location' => 'Hà Nội', 'content' => 'Đội ngũ làm việc rất tỉ mỉ và chuyên nghiệp. Căn nhà của tôi đẹp đúng như kỳ vọng, từng chi tiết đều chỉn chu.'],
            ['client_name' => 'Chị Mai', 'client_location' => 'Hải Phòng', 'content' => 'Tôi đặc biệt ấn tượng với khả năng tối giản mà vẫn sang trọng. Quy trình rõ ràng, bàn giao đúng hẹn.'],
            ['client_name' => 'Anh Tuấn', 'client_location' => 'Đà Nẵng', 'content' => 'Sự tận tâm và gu thẩm mỹ tinh tế đã thuyết phục tôi hoàn toàn. Rất đáng để hợp tác.'],
        ];
        foreach ($feedbacks as $i => $f) {
            ClientFeedback::updateOrCreate(['client_name' => $f['client_name']], $f + ['rating' => 5, 'sort_order' => $i, 'is_active' => true]);
        }

        // Bài viết (Cảm hứng / Góc tư vấn)
        $posts = [
            [
                'title' => '5 nguyên tắc vàng của không gian tối giản sang trọng',
                'category' => 'Xu hướng',
                'cover_image' => 'placeholders/post-1.jpg',
                'excerpt' => 'Tối giản không có nghĩa là trống trải. Cùng khám phá những nguyên tắc giúp không gian vừa tinh gọn vừa đẳng cấp.',
                'content' => '<p>Phong cách tối giản sang trọng (Minimalism Luxury) đề cao chất lượng hơn số lượng. Mỗi món đồ được lựa chọn kỹ lưỡng, mỗi khoảng trống đều có chủ đích.</p><h3>1. Bảng màu trung tính</h3><p>Trắng, kem, xám và các tông đất tạo nền tảng thanh lịch, để vật liệu và ánh sáng lên tiếng.</p><h3>2. Vật liệu thật</h3><p>Gỗ tự nhiên, đá, kim loại — chất liệu chân thực mang lại chiều sâu và sự bền vững.</p><h3>3. Ánh sáng nhiều lớp</h3><p>Kết hợp ánh sáng tự nhiên và chiếu sáng nghệ thuật để tôn lên kết cấu không gian.</p>',
            ],
            [
                'title' => 'Chọn vật liệu bền vững cho ngôi nhà hiện đại',
                'category' => 'Vật liệu',
                'cover_image' => 'placeholders/post-2.jpg',
                'excerpt' => 'Vật liệu không chỉ đẹp mà còn cần bền và thân thiện. Gợi ý cách chọn vật liệu vừa thẩm mỹ vừa lâu dài.',
                'content' => '<p>Một ngôi nhà đẹp bền vững bắt đầu từ việc chọn đúng vật liệu. Hãy ưu tiên những vật liệu có nguồn gốc rõ ràng, dễ bảo trì và phù hợp khí hậu.</p><p>Gỗ kỹ thuật, đá nung kết và sơn gốc nước là những lựa chọn vừa an toàn cho sức khỏe vừa giữ được vẻ đẹp theo thời gian.</p>',
            ],
            [
                'title' => 'Tận dụng ánh sáng tự nhiên trong thiết kế nội thất',
                'category' => 'Mẹo thiết kế',
                'cover_image' => 'placeholders/post-3.jpg',
                'excerpt' => 'Ánh sáng tự nhiên là "vật liệu" miễn phí và quyền lực nhất. Đây là cách khai thác tối đa nguồn sáng quý giá này.',
                'content' => '<p>Ánh sáng tự nhiên làm cho không gian rộng rãi, ấm áp và tốt cho sức khỏe. Hãy bố trí cửa sổ lớn, dùng rèm mỏng và bề mặt phản chiếu để khuếch tán ánh sáng.</p><p>Màu sơn sáng và gương đặt đúng vị trí sẽ nhân đôi hiệu quả chiếu sáng cho căn phòng.</p>',
            ],
        ];
        foreach ($posts as $i => $p) {
            Post::updateOrCreate(['slug' => \Illuminate\Support\Str::slug($p['title'])], $p + [
                'is_published' => true,
                'published_at' => now()->subDays(count($posts) - $i),
                'sort_order' => $i,
            ]);
        }

        // Trang chính sách (nội dung mẫu — chỉnh trong Admin)
        $pages = [
            [
                'title' => 'Chính sách bảo mật',
                'content' => '<p>Chúng tôi cam kết bảo vệ thông tin cá nhân của khách hàng. Trang này mô tả cách chúng tôi thu thập, sử dụng và bảo vệ dữ liệu của bạn.</p><h3>1. Thông tin thu thập</h3><p>Họ tên, số điện thoại, email và nội dung bạn cung cấp qua form đăng ký tư vấn.</p><h3>2. Mục đích sử dụng</h3><p>Liên hệ tư vấn, báo giá và chăm sóc khách hàng. Chúng tôi không chia sẻ thông tin cho bên thứ ba khi chưa có sự đồng ý của bạn.</p><h3>3. Bảo mật dữ liệu</h3><p>Dữ liệu được lưu trữ an toàn và chỉ những nhân sự có thẩm quyền mới được truy cập.</p>',
            ],
            [
                'title' => 'Điều khoản sử dụng',
                'content' => '<p>Khi truy cập và sử dụng website, bạn đồng ý với các điều khoản dưới đây.</p><h3>1. Quyền sở hữu nội dung</h3><p>Toàn bộ hình ảnh, bài viết và thiết kế trên website thuộc quyền sở hữu của chúng tôi, không được sao chép khi chưa được phép.</p><h3>2. Trách nhiệm người dùng</h3><p>Bạn cam kết cung cấp thông tin chính xác và không sử dụng website cho mục đích vi phạm pháp luật.</p>',
            ],
            [
                'title' => 'Chính sách bảo hành',
                'content' => '<p>Chúng tôi cam kết bảo hành cho các hạng mục thiết kế và thi công nội thất.</p><h3>Thời gian bảo hành</h3><p>Bảo hành tối thiểu 24 tháng cho phần thi công và sản phẩm nội thất do chúng tôi cung cấp.</p><h3>Điều kiện bảo hành</h3><p>Áp dụng cho lỗi kỹ thuật trong quá trình thi công và sản xuất. Không áp dụng cho hư hỏng do sử dụng sai cách hoặc tác động ngoại lực.</p>',
            ],
            [
                'title' => 'Chính sách thanh toán',
                'content' => '<p>Quy trình thanh toán minh bạch, rõ ràng theo từng giai đoạn.</p><h3>Các đợt thanh toán</h3><p>Thông thường chia thành các đợt: tạm ứng khi ký hợp đồng, thanh toán theo tiến độ thi công và quyết toán khi bàn giao.</p><h3>Phương thức</h3><p>Chuyển khoản ngân hàng hoặc tiền mặt. Mọi giao dịch đều có hợp đồng và chứng từ đầy đủ.</p>',
            ],
        ];
        foreach ($pages as $i => $pg) {
            Page::updateOrCreate(['slug' => \Illuminate\Support\Str::slug($pg['title'])], $pg + [
                'is_published' => true,
                'show_in_footer' => true,
                'sort_order' => $i,
            ]);
        }
    }
}
