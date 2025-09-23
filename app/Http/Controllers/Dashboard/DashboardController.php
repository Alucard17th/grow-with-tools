<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\ScheduledPost;
use App\Models\Lead;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Optional status filters
        $postStatus = $request->query('post_status', null);
        $leadStatus = $request->query('lead_status', null);

        // Fetch posts with optional filter
        $postsQuery = ScheduledPost::query()->orderBy('publish_at', 'desc');
        if ($postStatus) {
            $postsQuery->where('status', $postStatus);
        }
        $posts = $postsQuery->get();

        // Fetch leads with optional filter
        $leadsQuery = Lead::query()->orderBy('created_at', 'desc');
        if ($leadStatus) {
            $leadsQuery->where('status', $leadStatus);
        }
        $leads = $leadsQuery->get();

        // Summary statistics
        $postsStats = [
            'total' => ScheduledPost::count(),
            'published' => ScheduledPost::where('status', 'published')->count(),
            'failed' => ScheduledPost::where('status', 'failed')->count(),
        ];

        $leadsStats = [
            'total' => Lead::count(),
            'contacted' => Lead::where('status', 'contacted')->count(),
            'pending' => Lead::where('status', 'pending')->count(),
        ];

        return view('dashboard.dashboard', compact('posts', 'leads', 'postsStats', 'leadsStats', 'postStatus', 'leadStatus'));
    }
}
