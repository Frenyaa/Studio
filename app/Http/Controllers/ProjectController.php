<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectCategory;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /** Trang danh sách toàn bộ dự án (lọc theo danh mục). */
    public function index(Request $request)
    {
        $categories = ProjectCategory::active()->orderBy('sort_order')->get();

        $projects = Project::published()
            ->ordered()
            ->with('category')
            ->when($request->filled('category'), function ($query) use ($request) {
                $query->whereHas('category', fn ($q) => $q->where('slug', $request->category));
            })
            ->paginate(12)
            ->withQueryString();

        return view('projects.index', compact('projects', 'categories'));
    }

    /** Trang chi tiết một dự án. */
    public function show(Project $project)
    {
        abort_unless($project->is_published, 404);

        $project->load('images', 'category');

        $related = Project::published()
            ->where('id', '!=', $project->id)
            ->when($project->project_category_id, fn ($q) => $q->where('project_category_id', $project->project_category_id))
            ->ordered()
            ->take(3)
            ->get();

        return view('projects.show', compact('project', 'related'));
    }
}
