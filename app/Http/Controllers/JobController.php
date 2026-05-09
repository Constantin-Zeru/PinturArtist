<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Job;
use App\Models\Phase;
use App\Models\User;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $jobsQuery = Job::with(['client', 'users']);

        if ($user->role === 'trabajador') {
            $jobsQuery->whereHas('users', function ($query) use ($user) {
                $query->where('users.id', $user->id);
            });
        }

        $jobs = $jobsQuery->orderByDesc('created_at')->paginate(10);

        return view('jobs.index', compact('jobs'));
    }

    public function create()
    {
        abort_unless(auth()->user()->role === 'administrador', 403);

        $clients = Client::orderBy('name')->get();
        $workers = User::where('role', 'trabajador')->orderBy('name')->get();

        return view('jobs.create', compact('clients', 'workers'));
    }

    public function store(Request $request)
    {
        abort_unless(auth()->user()->role === 'administrador', 403);

        $validated = $request->validate([
            'client_id' => ['required', 'exists:clients,id'],
            'name' => ['required', 'string', 'max:255'],
            'work_type' => ['required', 'string', 'max:50'],
            'technical_state' => ['required', 'in:nuevo,regular,malo'],
            'description' => ['nullable', 'string'],
            'surface_m2' => ['nullable', 'numeric', 'min:0'],
            'rooms_count' => ['nullable', 'integer', 'min:0'],
            'height_m' => ['nullable', 'numeric', 'min:0'],
            'status' => ['required', 'in:pendiente,aceptado,en_proceso,pausado,finalizado,cancelado'],
            'priority' => ['required', 'in:baja,media,alta'],
            'requested_at' => ['nullable', 'date'],
            'planned_start_at' => ['nullable', 'date'],
            'planned_end_at' => ['nullable', 'date'],
            'technical_observations' => ['nullable', 'string'],
            'worker_ids' => ['nullable', 'array'],
            'worker_ids.*' => ['exists:users,id'],
        ]);

        $workerIds = $validated['worker_ids'] ?? [];
        unset($validated['worker_ids']);

        $job = Job::create($validated);
        $job->users()->sync($workerIds);

        return redirect()->route('jobs.index')->with('success', 'Encargo creado correctamente.');
    }

    public function show(Job $job)
    {
        $this->ensureJobVisibleToUser($job);

        $job->load(['client', 'users', 'budget', 'phases.responsibleUser', 'galleryItems.uploadedBy', 'incidents']);

        return view('jobs.show', compact('job'));
    }

    public function edit(Job $job)
    {
        abort_unless(auth()->user()->role === 'administrador', 403);

        $clients = Client::orderBy('name')->get();
        $workers = User::where('role', 'trabajador')->orderBy('name')->get();

        $job->load('users');

        return view('jobs.edit', compact('job', 'clients', 'workers'));
    }

    public function update(Request $request, Job $job)
    {
        abort_unless(auth()->user()->role === 'administrador', 403);

        $validated = $request->validate([
            'client_id' => ['required', 'exists:clients,id'],
            'name' => ['required', 'string', 'max:255'],
            'work_type' => ['required', 'string', 'max:50'],
            'technical_state' => ['required', 'in:nuevo,regular,malo'],
            'description' => ['nullable', 'string'],
            'surface_m2' => ['nullable', 'numeric', 'min:0'],
            'rooms_count' => ['nullable', 'integer', 'min:0'],
            'height_m' => ['nullable', 'numeric', 'min:0'],
            'status' => ['required', 'in:pendiente,aceptado,en_proceso,pausado,finalizado,cancelado'],
            'priority' => ['required', 'in:baja,media,alta'],
            'requested_at' => ['nullable', 'date'],
            'planned_start_at' => ['nullable', 'date'],
            'planned_end_at' => ['nullable', 'date'],
            'technical_observations' => ['nullable', 'string'],
            'worker_ids' => ['nullable', 'array'],
            'worker_ids.*' => ['exists:users,id'],
        ]);

        $workerIds = $validated['worker_ids'] ?? [];
        unset($validated['worker_ids']);

        $job->update($validated);
        $job->users()->sync($workerIds);

        return redirect()->route('jobs.index')->with('success', 'Encargo actualizado correctamente.');
    }

    public function destroy(Job $job)
    {
        abort_unless(auth()->user()->role === 'administrador', 403);

        $job->delete();

        return redirect()->route('jobs.index')->with('success', 'Encargo eliminado correctamente.');
    }

    public function phasesJson(Job $job)
    {
        $phases = $job->phases()
            ->orderBy('sort_order')
            ->orderBy('created_at')
            ->get(['id', 'name']);

        return response()->json($phases);
    }

    private function ensureJobVisibleToUser(Job $job): void
    {
        $user = auth()->user();

        if ($user->role === 'administrador') {
            return;
        }

        $allowed = $job->users()->where('users.id', $user->id)->exists();

        abort_unless($allowed, 403);
    }
}