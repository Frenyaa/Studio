<?php

namespace App\Providers;

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
use App\Models\WorkflowStep;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Tự xoá cache trang chủ mỗi khi nội dung liên quan thay đổi trong Admin.
        $models = [
            HeroSlide::class,
            Project::class,
            ProjectImage::class,
            ProjectCategory::class,
            Service::class,
            WorkflowStep::class,
            SiteStat::class,
            Partner::class,
            ClientFeedback::class,
            Post::class,
            Product::class,
            ProductCategory::class,
            ProductImage::class,
        ];

        foreach ($models as $model) {
            $model::saved(fn () => Cache::forget('homepage_data'));
            $model::deleted(fn () => Cache::forget('homepage_data'));
        }

        // Xoá cache danh sách trang ở footer khi có thay đổi
        Page::saved(fn () => Cache::forget('footer_pages'));
        Page::deleted(fn () => Cache::forget('footer_pages'));

        // Xoá cache danh mục trên menu khi có thay đổi
        ProductCategory::saved(fn () => Cache::forget('nav_product_cats'));
        ProductCategory::deleted(fn () => Cache::forget('nav_product_cats'));
        ProjectCategory::saved(fn () => Cache::forget('nav_project_cats'));
        ProjectCategory::deleted(fn () => Cache::forget('nav_project_cats'));

        // Chia sẻ cài đặt website cho form tư vấn + dải CTA
        View::composer(['partials.contact', 'partials.cta'], function ($view) {
            $view->with('settings', Setting::allCached());
        });

        // Chia sẻ danh sách trang chính sách + cài đặt website cho footer (mọi trang)
        View::composer('partials.footer', function ($view) {
            $view->with('footerPages', Cache::remember('footer_pages', now()->addMinutes(30), function () {
                return Page::published()
                    ->where('show_in_footer', true)
                    ->orderBy('sort_order')
                    ->get(['title', 'slug']);
            }));
            $view->with('settings', Setting::allCached());
        });

        // Chia sẻ danh mục cho menu điều hướng (dropdown)
        View::composer('partials.nav', function ($view) {
            $view->with('navProductCategories', Cache::remember('nav_product_cats', now()->addMinutes(30), fn () => ProductCategory::where('is_active', true)->orderBy('sort_order')->get(['name', 'slug'])));
            $view->with('navProjectCategories', Cache::remember('nav_project_cats', now()->addMinutes(30), fn () => ProjectCategory::where('is_active', true)->orderBy('sort_order')->get(['name', 'slug'])));
            $view->with('navBlogCategories', Post::CATEGORIES);
        });

        // Chia sẻ tên + logo thương hiệu cho menu, footer, layout
        View::composer(['layouts.app', 'partials.nav', 'partials.footer'], function ($view) {
            $view->with('siteName', Setting::getValue('site_name', config('app.name')));
            $view->with('siteLogo', Setting::getValue('site_logo', ''));
        });
    }
}
