<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Spatie\Activitylog\Models\Activity;

class ActivityController extends Controller
{
    public function database(string $on, int $id)
    {
        $activities = Activity::where('subject_type', "App\\Models\\{$on}")
            ->with('causer')
            ->where('log_name', 'like', "Database")
            ->orderBy('created_at', 'DESC')
            ->where('subject_id', $id)
            ->get();


        return Inertia::render('Activities/Database', [
            'activities'               => $activities,
        ]);
    }

    public function userAccess(User $user) {
        $activities = Activity::where('causer_type', User::class)
            ->where('causer_id', $user->id)
            ->where('log_name', 'like', "User Accessed")
            ->with('subject')
            ->orderBy('created_at', 'DESC')
            ->get();

        return Inertia::render('Activities/UserAccess', [
            'activities' => $activities
        ]);

    }


}
