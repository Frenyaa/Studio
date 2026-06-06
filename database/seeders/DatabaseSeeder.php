<?php

namespace Database\Seeders;

use App\Models\ClientFeedback;
use App\Models\HeroSlide;
use App\Models\Page;
use App\Models\Partner;
use App\Models\Post;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\ProjectImage;
use App\Models\Service;
use App\Models\Setting;
use App\Models\SiteStat;
use App\Models\User;
use App\Models\WorkflowStep;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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
            'video_file' => 'hero/videos/hero-demo.mp4',
            'poster_image' => 'placeholders/hero.jpg',
            'slogan' => 'NỘI THẤT CAO CẤP CHO KHÔNG GIAN SỐNG TINH TẾ',
            'sub_slogan' => 'Tối giản · Sang trọng · Bền vững',
            'cta_label' => 'XEM SẢN PHẨM',
            'cta_anchor' => '#categories',
            'show_logo_overlay' => true,
            'is_active' => true,
        ]);

        // ===== DỰ ÁN (công trình thiết kế nội thất) =====
        $projectCats = collect([
            ['name' => 'Căn hộ', 'slug' => 'can-ho'],
            ['name' => 'Biệt thự', 'slug' => 'biet-thu'],
            ['name' => 'Nhà phố', 'slug' => 'nha-pho'],
            ['name' => 'Thương mại', 'slug' => 'thuong-mai'],
        ])->map(fn ($c, $i) => ProjectCategory::updateOrCreate(['slug' => $c['slug']], $c + ['sort_order' => $i, 'is_active' => true]));

        $projects = [
            ['title' => 'Brave House', 'cat' => 'biet-thu', 'img' => 1, 'location' => 'Hà Nội', 'area' => '320m²', 'style' => 'Tối giản sang trọng',
             'summary' => 'Biệt thự tối giản với gam trung tính, ánh sáng tự nhiên ngập tràn và nội thất gỗ óc chó ấm áp.',
             'desc' => '<p>Một dự án thiết kế &amp; thi công nội thất trọn gói cho biệt thự, theo triết lý "less is more". Không gian mở liên thông giữa phòng khách, bếp và khu vực ăn uống giúp ánh sáng tự nhiên len lỏi khắp nơi.</p><p>Toàn bộ nội thất được thiết kế riêng (custom) theo công trình: gỗ óc chó, đá tự nhiên và sơn hiệu ứng tông trung tính.</p>'],
            ['title' => 'Teasu House', 'cat' => 'nha-pho', 'img' => 2, 'location' => 'Hải Phòng', 'area' => '180m²', 'style' => 'Japandi',
             'summary' => 'Nhà phố tinh gọn, tối ưu công năng theo chiều đứng, nội thất mộc mạc theo tinh thần Japandi.',
             'desc' => '<p>Dự án nhà phố với giếng trời trung tâm xuyên suốt các tầng, kết hợp hệ nội thất thiết kế riêng tối ưu cho không gian hẹp ngang.</p>'],
            ['title' => 'Metropolis Apartment', 'cat' => 'can-ho', 'img' => 3, 'location' => 'Hà Nội', 'area' => '120m²', 'style' => 'Hiện đại',
             'summary' => 'Căn hộ hiện đại tông xám than &amp; đồng thau, nội thất đặt làm tối ưu lưu trữ.',
             'desc' => '<p>Thiết kế &amp; thi công nội thất căn hộ với hệ tủ âm tường kịch trần, bàn ghế và sofa đặt làm theo kích thước thực tế.</p>'],
            ['title' => 'Serene Apartment', 'cat' => 'can-ho', 'img' => 4, 'location' => 'Đà Nẵng', 'area' => '95m²', 'style' => 'Japandi',
             'summary' => 'Căn hộ nhỏ ấm cúng, nội thất tuyển chọn theo tiêu chí "ít nhưng chất".',
             'desc' => '<p>Dự án căn hộ theo phong cách Japandi — giao thoa tối giản Bắc Âu và tinh thần thiền Nhật Bản.</p>'],
            ['title' => 'Lumiere Villa', 'cat' => 'biet-thu', 'img' => 5, 'location' => 'Hà Nội', 'area' => '450m²', 'style' => 'Luxury',
             'summary' => 'Biệt thự cao cấp tôn vinh ánh sáng, nội thất thủ công đặt riêng.',
             'desc' => '<p>Công trình biến ánh sáng tự nhiên thành vật liệu thiết kế chủ đạo, đi kèm hệ nội thất bọc da và đá vân mây đặt làm riêng.</p>'],
            ['title' => 'Maison Office', 'cat' => 'thuong-mai', 'img' => 6, 'location' => 'TP.HCM', 'area' => '600m²', 'style' => 'Đương đại',
             'summary' => 'Văn phòng thương mại truyền cảm hứng, nội thất thiết kế theo nhận diện thương hiệu.',
             'desc' => '<p>Thiết kế &amp; thi công nội thất văn phòng: khu làm việc mở, phòng họp kính và khu thư giãn xanh mát, đồ nội thất đặt làm đồng bộ.</p>'],
        ];
        foreach ($projects as $i => $p) {
            $project = Project::updateOrCreate(['slug' => Str::slug($p['title'])], [
                'title' => $p['title'],
                'project_category_id' => $projectCats->firstWhere('slug', $p['cat'])?->id,
                'location' => $p['location'],
                'area' => $p['area'],
                'year_completed' => 2024,
                'style' => $p['style'],
                'cover_image' => 'placeholders/project-' . $p['img'] . '.jpg',
                'summary' => $p['summary'],
                'description' => $p['desc'],
                'is_featured' => true,
                'is_published' => true,
                'sort_order' => $i,
            ]);
            if ($project->images()->count() === 0) {
                for ($g = 1; $g <= 4; $g++) {
                    $n = (($i + $g) % 6) + 1;
                    ProjectImage::create(['project_id' => $project->id, 'image' => 'placeholders/project-' . $n . '.jpg', 'sort_order' => $g]);
                }
            }
        }

        // ===== SẢN PHẨM (bán lẻ, phân loại theo loại đồ) =====
        $productCats = collect([
            ['name' => 'Sofa', 'slug' => 'sofa'],
            ['name' => 'Bàn', 'slug' => 'ban'],
            ['name' => 'Ghế', 'slug' => 'ghe'],
            ['name' => 'Tủ & Kệ', 'slug' => 'tu-ke'],
            ['name' => 'Giường', 'slug' => 'giuong'],
            ['name' => 'Thảm', 'slug' => 'tham'],
            ['name' => 'Bàn ghế ngoài trời', 'slug' => 'ngoai-troi'],
        ])->map(fn ($c, $i) => ProductCategory::updateOrCreate(['slug' => $c['slug']], $c + ['sort_order' => $i, 'is_active' => true]));

        $products = [
            ['name' => 'Sofa Góc Socco', 'cat' => 'sofa', 'img' => 1, 'sku' => 'V1.0',
             'dimensions' => 'D2800 x R1600 (mm)',
             'material' => "Khung gỗ dầu chống cong vênh, mối mọt.\nNệm mousse D40 dày 15cm, độ đàn hồi cao gấp 40% so với mousse thông thường.",
             'colors' => 'Hơn 200 màu vải, da: Bố, Nhung, Nỉ, Da công nghiệp.',
             'summary' => 'Sofa góc bọc nỉ êm ái, khung gỗ dầu bền chắc, tự do phối màu và kích thước.',
             'desc' => '<p>Bạn có thể tự do phối màu và kích thước theo sở thích; với sofa góc, chọn hướng góc theo không gian bố trí.</p>'],
            ['name' => 'Sofa Băng Minimal', 'cat' => 'sofa', 'img' => 2, 'sku' => 'SF.02',
             'dimensions' => 'D2200 x R900 (mm)',
             'material' => 'Khung gỗ tự nhiên, nệm mút D40 bọc vải/da.',
             'colors' => 'Kem, Ghi, Xanh rêu, Nâu.',
             'summary' => 'Sofa băng dáng thấp tối giản, phù hợp căn hộ và phòng khách nhỏ.',
             'desc' => '<p>Thiết kế dáng thấp thanh thoát, đường nét tối giản, dễ phối với mọi không gian.</p>'],
            ['name' => 'Bàn Làm Việc Gỗ Óc Chó', 'cat' => 'ban', 'img' => 3, 'sku' => 'BLV.03',
             'dimensions' => 'D1400 x R700 x C750 (mm)',
             'material' => 'Gỗ óc chó nguyên khối, phủ dầu lau tự nhiên.',
             'colors' => 'Nâu óc chó tự nhiên.',
             'summary' => 'Bàn làm việc gỗ óc chó nguyên khối, ấm áp và sang trọng.',
             'desc' => '<p>Gỗ óc chó nhập khẩu vân đẹp tự nhiên, hoàn thiện dầu lau an toàn cho sức khỏe.</p>'],
            ['name' => 'Bàn Trà Mặt Đá Marble', 'cat' => 'ban', 'img' => 4, 'sku' => 'BT.04',
             'dimensions' => 'D1200 x R600 x C420 (mm)',
             'material' => 'Mặt đá marble tự nhiên, chân gỗ sồi phủ PU.',
             'colors' => 'Trắng vân mây, Đen kim sa, Ghi xi măng.',
             'summary' => 'Bàn trà mặt đá marble sang trọng, chân gỗ sồi vững chãi.',
             'desc' => '<p>Mặt đá marble vân độc bản, xử lý chống thấm, dễ vệ sinh.</p>'],
            ['name' => 'Ghế Armchair Bọc Nỉ', 'cat' => 'ghe', 'img' => 5, 'sku' => 'GH.05',
             'dimensions' => 'D750 x R780 x C800 (mm)',
             'material' => 'Khung gỗ sồi, bọc nỉ cao cấp, mút đệm êm.',
             'colors' => 'Be, Ghi, Xanh cổ vịt, Nâu tằm.',
             'summary' => 'Ghế armchair ôm lưng êm ái, điểm nhấn thư giãn cho góc đọc sách.',
             'desc' => '<p>Dáng ghế ôm trọn lưng, đệm êm, khung gỗ sồi chắc chắn.</p>'],
            ['name' => 'Tủ Quần Áo Acrylic', 'cat' => 'tu-ke', 'img' => 6, 'sku' => 'TU.06',
             'dimensions' => 'Thiết kế theo không gian thực tế',
             'material' => 'Thùng gỗ MDF lõi xanh chống ẩm, cánh phủ Acrylic bóng gương.',
             'colors' => 'Trắng, Kem, Xám, vân gỗ.',
             'summary' => 'Tủ quần áo Acrylic bóng gương, chống ẩm, tối ưu lưu trữ.',
             'desc' => '<p>Bề mặt Acrylic sang trọng, chống trầy, phụ kiện ray trượt giảm chấn nhập khẩu.</p>'],
            ['name' => 'Kệ TV Gỗ Tự Nhiên', 'cat' => 'tu-ke', 'img' => 1, 'sku' => 'KE.07',
             'dimensions' => 'D1800 x R400 x C450 (mm)',
             'material' => 'Gỗ tự nhiên kết hợp khung kim loại sơn tĩnh điện.',
             'colors' => 'Nâu gỗ, Đen.',
             'summary' => 'Kệ TV gỗ tự nhiên dáng thấp, gọn gàng và tinh tế.',
             'desc' => '<p>Kết hợp gỗ tự nhiên và kim loại, ngăn kéo êm, tối ưu cho phòng khách.</p>'],
            ['name' => 'Giường Ngủ Bọc Nệm', 'cat' => 'giuong', 'img' => 2, 'sku' => 'GN.08',
             'dimensions' => 'D2000 x R1800 (mm)',
             'material' => 'Khung gỗ tự nhiên, đầu giường bọc nệm cao cấp.',
             'colors' => 'Be, Ghi, Nâu tằm, Xanh rêu.',
             'summary' => 'Giường ngủ đầu bọc nệm êm ái, khung gỗ chắc chắn.',
             'desc' => '<p>Đầu giường bọc nệm tựa lưng êm, khung gỗ bền theo thời gian.</p>'],
            ['name' => 'Thảm Dệt Nhập Khẩu', 'cat' => 'tham', 'img' => 3, 'sku' => 'TM.09',
             'dimensions' => '1600 x 2300 (mm)',
             'material' => 'Sợi lông cừu pha viscose, dệt thủ công.',
             'colors' => 'Kem, Ghi sáng, Xám khói.',
             'summary' => 'Thảm dệt thủ công nhập khẩu, sợi mềm mịn, ấm cúng.',
             'desc' => '<p>Chất sợi cao cấp, bề mặt mềm mịn, giữ ấm tốt và bền màu.</p>'],
            ['name' => 'Bộ Bàn Ghế Sân Vườn', 'cat' => 'ngoai-troi', 'img' => 4, 'sku' => 'NT.10',
             'dimensions' => 'Bộ gồm 1 bàn + 4 ghế',
             'material' => 'Khung nhôm đúc sơn tĩnh điện, đan dây nhựa giả mây chịu thời tiết.',
             'colors' => 'Nâu, Xám, Đen.',
             'summary' => 'Bộ bàn ghế ngoài trời chịu thời tiết, khung nhôm bền nhẹ.',
             'desc' => '<p>Chịu nắng mưa, không gỉ sét, phù hợp sân vườn, ban công, hồ bơi; đệm tháo rời dễ vệ sinh.</p>'],
        ];
        foreach ($products as $i => $p) {
            $product = Product::updateOrCreate(['slug' => Str::slug($p['name'])], [
                'name' => $p['name'],
                'product_category_id' => $productCats->firstWhere('slug', $p['cat'])?->id,
                'sku' => $p['sku'],
                'dimensions' => $p['dimensions'],
                'material' => $p['material'],
                'colors' => $p['colors'],
                'cover_image' => 'placeholders/project-' . $p['img'] . '.jpg',
                'summary' => $p['summary'],
                'description' => $p['desc'],
                'is_featured' => true,
                'is_published' => true,
                'sort_order' => $i,
            ]);
            if ($product->images()->count() === 0) {
                for ($g = 1; $g <= 4; $g++) {
                    $n = (($i + $g) % 6) + 1;
                    ProductImage::create(['product_id' => $product->id, 'image' => 'placeholders/project-' . $n . '.jpg', 'sort_order' => $g]);
                }
            }
        }

        // Dịch vụ
        $services = [
            ['title' => 'Đặt làm theo yêu cầu', 'summary' => 'Tùy chỉnh kích thước, màu vải/da và chất liệu theo đúng không gian và sở thích của bạn.'],
            ['title' => 'Vật liệu cao cấp', 'summary' => 'Gỗ tự nhiên, da, nỉ nhập khẩu — bền đẹp theo thời gian, an toàn cho sức khỏe.'],
            ['title' => 'Giao lắp & Bảo hành', 'summary' => 'Giao hàng, lắp đặt tận nơi và bảo hành dài hạn, đồng hành cùng bạn lâu dài.'],
        ];
        foreach ($services as $i => $s) {
            Service::updateOrCreate(['slug' => Str::slug($s['title'])], $s + ['sort_order' => $i, 'is_active' => true]);
        }

        // Quy trình
        $steps = [
            ['number' => '01', 'title' => 'Tư vấn', 'description' => 'Lắng nghe nhu cầu, gu thẩm mỹ và không gian của bạn.'],
            ['number' => '02', 'title' => 'Chọn mẫu & vật liệu', 'description' => 'Lựa chọn thiết kế, màu vải/da, chất liệu và kích thước phù hợp.'],
            ['number' => '03', 'title' => 'Sản xuất', 'description' => 'Gia công tại xưởng với vật liệu được kiểm soát chất lượng nghiêm ngặt.'],
            ['number' => '04', 'title' => 'Giao hàng & Lắp đặt', 'description' => 'Vận chuyển, lắp đặt tận nơi và bảo hành chu đáo.'],
        ];
        foreach ($steps as $i => $s) {
            WorkflowStep::updateOrCreate(['title' => $s['title']], $s + ['sort_order' => $i, 'is_active' => true]);
        }

        // Chỉ số
        $stats = [
            ['value' => '10', 'suffix' => '+', 'label' => 'Năm kinh nghiệm'],
            ['value' => '500', 'suffix' => '+', 'label' => 'Mẫu nội thất'],
            ['value' => '2000', 'suffix' => '+', 'label' => 'Khách hàng hài lòng'],
            ['value' => '24', 'suffix' => ' tháng', 'label' => 'Bảo hành sản phẩm'],
        ];
        foreach ($stats as $i => $s) {
            SiteStat::updateOrCreate(['label' => $s['label']], $s + ['sort_order' => $i, 'is_active' => true]);
        }

        // Đối tác
        foreach (['Kohler', 'Dulux', 'Toto', 'Häfele', 'Caesar', 'An Cường'] as $i => $name) {
            Partner::updateOrCreate(['name' => $name], [
                'logo' => 'placeholders/partner-' . ($i + 1) . '.svg',
                'sort_order' => $i,
                'is_active' => true,
            ]);
        }

        // Feedback
        $feedbacks = [
            ['client_name' => 'Anh Kiên', 'client_location' => 'Hà Nội', 'content' => 'Bộ sofa đúng như hình, chất vải đẹp và rất êm. Giao lắp nhanh, nhân viên tư vấn nhiệt tình.'],
            ['client_name' => 'Chị Mai', 'client_location' => 'Hải Phòng', 'content' => 'Mình rất ưng chất lượng gỗ và độ hoàn thiện. Được phối màu theo yêu cầu, sang trọng đúng gu.'],
            ['client_name' => 'Anh Tuấn', 'client_location' => 'Đà Nẵng', 'content' => 'Sản phẩm cao cấp, đáng tiền. Chế độ bảo hành chu đáo, chắc chắn sẽ tiếp tục ủng hộ.'],
        ];
        foreach ($feedbacks as $i => $f) {
            ClientFeedback::updateOrCreate(['client_name' => $f['client_name']], $f + ['rating' => 5, 'sort_order' => $i, 'is_active' => true]);
        }

        // Bài viết (Blog) — chủ đề dùng slug theo Post::CATEGORIES
        $posts = [
            ['title' => '5 nguyên tắc vàng của không gian tối giản sang trọng', 'category' => 'xu-huong', 'cover_image' => 'placeholders/post-1.jpg',
             'excerpt' => 'Tối giản không có nghĩa là trống trải. Cùng khám phá những nguyên tắc giúp không gian vừa tinh gọn vừa đẳng cấp.',
             'content' => '<p>Phong cách tối giản sang trọng đề cao chất lượng hơn số lượng.</p><h3>1. Bảng màu trung tính</h3><p>Trắng, kem, xám và các tông đất tạo nền tảng thanh lịch.</p><h3>2. Vật liệu thật</h3><p>Gỗ tự nhiên, đá, kim loại mang lại chiều sâu và sự bền vững.</p><h3>3. Ánh sáng nhiều lớp</h3><p>Kết hợp ánh sáng tự nhiên và chiếu sáng nghệ thuật.</p>'],
            ['title' => 'Chọn vật liệu bền vững cho ngôi nhà hiện đại', 'category' => 'vat-lieu', 'cover_image' => 'placeholders/post-2.jpg',
             'excerpt' => 'Vật liệu không chỉ đẹp mà còn cần bền và thân thiện. Gợi ý cách chọn vật liệu vừa thẩm mỹ vừa lâu dài.',
             'content' => '<p>Hãy ưu tiên vật liệu có nguồn gốc rõ ràng, dễ bảo trì và phù hợp khí hậu.</p><p>Gỗ kỹ thuật, đá nung kết và sơn gốc nước là lựa chọn an toàn và bền đẹp.</p>'],
            ['title' => 'Tận dụng ánh sáng tự nhiên trong thiết kế nội thất', 'category' => 'meo-thiet-ke', 'cover_image' => 'placeholders/post-3.jpg',
             'excerpt' => 'Ánh sáng tự nhiên là "vật liệu" miễn phí và quyền lực nhất. Đây là cách khai thác tối đa nguồn sáng quý giá này.',
             'content' => '<p>Bố trí cửa sổ lớn, dùng rèm mỏng và bề mặt phản chiếu để khuếch tán ánh sáng.</p><p>Màu sơn sáng và gương đặt đúng vị trí sẽ nhân đôi hiệu quả chiếu sáng.</p>'],
            ['title' => 'Lấy cảm hứng phối màu từ thiên nhiên', 'category' => 'cam-hung-sang-tao', 'cover_image' => 'placeholders/post-1.jpg',
             'excerpt' => 'Những bảng màu lấy cảm hứng từ thiên nhiên mang lại sự ấm áp và cân bằng cho không gian sống.',
             'content' => '<p>Tông đất, xanh rêu, be cát... gợi cảm giác thư thái, gần gũi.</p><p>Kết hợp vật liệu mộc và cây xanh để hoàn thiện tổng thể.</p>'],
            ['title' => 'Phong cách Japandi: giao thoa Bắc Âu và Nhật Bản', 'category' => 'phong-cach', 'cover_image' => 'placeholders/post-2.jpg',
             'excerpt' => 'Japandi cân bằng giữa sự ấm cúng Scandinavian và tinh thần tối giản, thiền định của Nhật Bản.',
             'content' => '<p>Đường nét mộc mạc, vật liệu tự nhiên và bảng màu trung tính là cốt lõi của Japandi.</p>'],
            ['title' => 'Kinh nghiệm chọn sofa bền đẹp theo thời gian', 'category' => 'kinh-nghiem', 'cover_image' => 'placeholders/post-3.jpg',
             'excerpt' => 'Chọn sofa không chỉ nhìn đẹp — khung, nệm và chất liệu bọc mới quyết định độ bền.',
             'content' => '<p>Ưu tiên khung gỗ tự nhiên đã xử lý, nệm mật độ cao và vải/da dễ vệ sinh.</p>'],
        ];
        foreach ($posts as $i => $p) {
            Post::updateOrCreate(['slug' => Str::slug($p['title'])], $p + [
                'is_published' => true,
                'published_at' => now()->subDays(count($posts) - $i),
                'sort_order' => $i,
            ]);
        }

        // Trang chính sách (nội dung mẫu — chỉnh trong Admin)
        $pages = [
            ['title' => 'Chính sách bảo mật', 'content' => '<p>Chúng tôi cam kết bảo vệ thông tin cá nhân của khách hàng.</p><h3>1. Thông tin thu thập</h3><p>Họ tên, số điện thoại, email và nội dung bạn cung cấp qua form đăng ký tư vấn.</p><h3>2. Mục đích sử dụng</h3><p>Liên hệ tư vấn, báo giá và chăm sóc khách hàng.</p><h3>3. Bảo mật dữ liệu</h3><p>Dữ liệu được lưu trữ an toàn, chỉ nhân sự có thẩm quyền mới truy cập.</p>'],
            ['title' => 'Điều khoản sử dụng', 'content' => '<p>Khi sử dụng website, bạn đồng ý với các điều khoản dưới đây.</p><h3>1. Quyền sở hữu nội dung</h3><p>Hình ảnh, bài viết, thiết kế trên website thuộc quyền sở hữu của chúng tôi.</p><h3>2. Trách nhiệm người dùng</h3><p>Cung cấp thông tin chính xác, không dùng website cho mục đích vi phạm pháp luật.</p>'],
            ['title' => 'Chính sách bảo hành', 'content' => '<p>Cam kết bảo hành cho sản phẩm và hạng mục thi công nội thất.</p><h3>Thời gian</h3><p>Tối thiểu 24 tháng cho sản phẩm và phần thi công do chúng tôi cung cấp.</p><h3>Điều kiện</h3><p>Áp dụng cho lỗi kỹ thuật; không áp dụng cho hư hỏng do sử dụng sai cách hoặc tác động ngoại lực.</p>'],
            ['title' => 'Chính sách thanh toán', 'content' => '<p>Quy trình thanh toán minh bạch theo từng giai đoạn.</p><h3>Các đợt</h3><p>Tạm ứng khi ký hợp đồng, thanh toán theo tiến độ và quyết toán khi bàn giao.</p><h3>Phương thức</h3><p>Chuyển khoản hoặc tiền mặt, có hợp đồng và chứng từ đầy đủ.</p>'],
        ];
        foreach ($pages as $i => $pg) {
            Page::updateOrCreate(['slug' => Str::slug($pg['title'])], $pg + [
                'is_published' => true,
                'show_in_footer' => true,
                'sort_order' => $i,
            ]);
        }

        // Cài đặt website (liên hệ + mạng xã hội) — chỉnh trong Admin → Cài đặt website
        $settings = [
            'site_name' => 'STUDIO',
            'footer_about' => 'Thiết kế & thi công nội thất toàn diện theo phong cách tối giản sang trọng — kiến tạo không gian sống tinh tế, bền vững theo thời gian.',
            'footer_slogan' => 'Nội Thất Cao Cấp | Tối Giản & Sang Trọng',
            'footer_copyright' => '© {year} {brand}. All rights reserved.',
            'contact_address' => 'Vũ Tông Phan, Thanh Xuân, Hà Nội',
            'contact_hotline' => '0900 000 000',
            'contact_email' => 'hello@studio.vn',
            'social_facebook' => 'https://facebook.com',
            'social_youtube' => 'https://youtube.com',
            'social_tiktok' => 'https://tiktok.com',
            'social_zalo' => '',
        ];
        foreach ($settings as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }
    }
}
