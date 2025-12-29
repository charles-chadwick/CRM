<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Spatie\Activitylog\Models\Activity;

class ActivityController extends Controller
{
    public function index(string $on, int $id)
    {
        $activities = Activity::where('subject_type', "App\\Models\\{$on}")
            ->with('causer')
            ->where('log_name', '!=', 'auth.login')
            ->orderBy('created_at', 'DESC')
            ->where('subject_id', $id)
            ->get();

        return Inertia::render('Activities/Index', [
            'activities' => $activities
        ]);
    }
}
