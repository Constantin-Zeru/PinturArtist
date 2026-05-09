<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Job;
use App\Models\Budget;
use App\Models\Phase;
use App\Models\GalleryItem;
use App\Models\Incident;
use App\Models\Material;

class PanelController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'administrador') {
            return view('panel', [
                'role' => $user->role,
                'clientsCount' => Client::count(),
                'jobsCount' => Job::count(),
                'budgetsCount' => Budget::count(),
                'phasesCount' => Phase::count(),
                'galleryCount' => GalleryItem::count(),
                'incidentsCount' => Incident::count(),
                'materialsCount' => Material::count(),
                'recentJobs' => Job::with('client')->latest()->take(5)->get(),
            ]);
        }

        if ($user->role === 'trabajador') {
            $jobsQuery = Job::with('client')
                ->whereHas('users', function ($query) use ($user) {
                    $query->where('users.id', $user->id);
                });

            return view('panel', [
                'role' => $user->role,
                'jobsCount' => (clone $jobsQuery)->count(),
                'phasesCount' => Phase::where('responsible_user_id', $user->id)->count(),
                'galleryCount' => GalleryItem::where('uploaded_by', $user->id)->count(),
                'incidentsCount' => Incident::where('reported_by', $user->id)->count(),
                'recentJobs' => $jobsQuery->latest()->take(5)->get(),
            ]);
        }

        abort(403);
    }
}