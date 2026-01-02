<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Spatie\Activitylog\Models\Activity;
use Spatie\Browsershot\Browsershot;
use Throwable;

class ActivityController extends Controller
{
    public function index(string $on, int $id)
    {
        $activities = Activity::where('subject_type', "App\\Models\\{$on}")
            ->with('causer')
            ->where('log_name', '=', 'database')
            ->orderBy('created_at', 'DESC')
            ->where('subject_id', $id)
            ->get();

        return Inertia::render('Activities/Index', [
            'activities' => $activities
        ]);
    }

    /**
     * @throws Throwable
     */
    public function downloadPdf(string $on, int $id)
    {
        $activities = Activity::where('subject_type', "App\\Models\\{$on}")
            ->with('causer')
            ->orderBy('created_at', 'DESC')
            ->where('log_name', '=', 'database')
            ->where('subject_id', $id)
            ->get();

        $html = view('activities.pdf', [
            'activities'   => $activities,
            'subject_type' => $on,
            'subject_id'   => $id
        ])->render();

        $pdf = Browsershot::html($html)
            ->format('A4')
            ->pdf();

        return response($pdf)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="activities-'.$on.'-'.$id.'.pdf"');
    }

}
