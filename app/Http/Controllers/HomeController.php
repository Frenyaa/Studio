<?php

namespace App\Http\Controllers;

use App\Models\ClientFeedback;
use App\Models\HeroSlide;
use App\Models\Partner;
use App\Models\Post;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\Service;
use App\Models\SiteStat;
use App\Models\WorkflowStep;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index()
    {
        // Cache 10 phút để trang tải cực nhanh; tự xoá khi admin lưu (xem AppServiceProvider).
        $data = Cache::remember('homepage_data', now()->addMinutes(10), function () {
            return [
                'hero' => HeroSlide::active()->orderBy('sort_order')->first(),

                'featuredProjects' => Project::published()
                    ->featured()
                    ->ordered()
                    ->with('category')
                    ->take(6)
                    ->get(),

                'spotlight' => Project::published()
                    ->featured()
                    ->ordered()
                    ->with('category')
                    ->first(),

                'posts' => Post::published()->latestPosts()->take(3)->get(),

                'categories' => ProjectCategory::active()
                    ->orderBy('sort_order')
                    ->with(['projects' => fn ($q) => $q->where('is_published', true)->orderBy('sort_order')])
                    ->get(),

                'services' => Service::active()->orderBy('sort_order')->get(),

                'workflowSteps' => WorkflowStep::active()->orderBy('sort_order')->get(),

                'stats' => SiteStat::active()->orderBy('sort_order')->get(),

                'partners' => Partner::active()->orderBy('sort_order')->get(),

                'feedbacks' => ClientFeedback::active()->orderBy('sort_order')->get(),
            ];
        });

        return view('home', $data);
    }
}
