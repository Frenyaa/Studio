<?php

namespace App\Http\Controllers;

use App\Models\ClientFeedback;
use App\Models\Partner;
use App\Models\Post;
use App\Models\Service;
use App\Models\SiteStat;
use App\Models\WorkflowStep;
use Illuminate\Support\Facades\Cache;

class AboutController extends Controller
{
    public function index()
    {
        // Cache 10 phút; tự xoá khi admin lưu nội dung liên quan (xem AppServiceProvider).
        $data = Cache::remember('about_data', now()->addMinutes(10), function () {
            return [
                'services' => Service::active()->orderBy('sort_order')->get(),

                'stats' => SiteStat::active()->orderBy('sort_order')->get(),

                'workflowSteps' => WorkflowStep::active()->orderBy('sort_order')->get(),

                'partners' => Partner::active()->orderBy('sort_order')->get(),

                'feedbacks' => ClientFeedback::active()->orderBy('sort_order')->get(),

                'posts' => Post::published()->latestPosts()->take(3)->get(),
            ];
        });

        return view('about', $data);
    }
}
