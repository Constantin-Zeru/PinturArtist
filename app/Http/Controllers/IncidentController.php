<?php

namespace App\Http\Controllers;

use App\Models\Incident;
use App\Models\Job;
use App\Models\Phase;
use Illuminate\Http\Request;

class IncidentController extends Controller
{
    public function index()
    {
        $incidents = Incident::with(['job.client', 'phase', 'reportedBy'])
            ->orderByDesc('incident_date')
            ->paginate(10);

        return view('incidents.index', compact('incidents'));
    }

    public function create()
    {
        $jobs = Job::with('client')->orderByDesc('created_at')->get();
        $phases = Phase::with('job.client')->orderByDesc('created_at')->get();

        return view('incidents.create', compact('jobs', 'phases'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'job_id' => ['required', 'exists:jobs,id'],
            'phase_id' => ['nullable', 'exists:phases,id'],
            'cause' => ['required', 'string'],
            'incident_date' => ['required', 'date'],
            'resolution' => ['nullable', 'string'],
            'delay_minutes' => ['nullable', 'integer', 'min:0'],
            'affects_budget' => ['nullable', 'boolean'],
            'affects_deadline' => ['nullable', 'boolean'],
            'status' => ['required', 'in:abierta,en_proceso,resuelta'],
        ]);

        $validated['reported_by'] = auth()->id();
        $validated['affects_budget'] = $request->boolean('affects_budget');
        $validated['affects_deadline'] = $request->boolean('affects_deadline');

        Incident::create($validated);

        return redirect()->route('incidents.index')->with('success', 'Incidencia creada correctamente.');
    }

    public function show(Incident $incident)
    {
        $incident->load(['job.client', 'phase', 'reportedBy']);

        return view('incidents.show', compact('incident'));
    }

    public function edit(Incident $incident)
    {
        $jobs = Job::with('client')->orderByDesc('created_at')->get();
        $phases = Phase::with('job.client')->orderByDesc('created_at')->get();

        return view('incidents.edit', compact('incident', 'jobs', 'phases'));
    }

    public function update(Request $request, Incident $incident)
    {
        $validated = $request->validate([
            'job_id' => ['required', 'exists:jobs,id'],
            'phase_id' => ['nullable', 'exists:phases,id'],
            'cause' => ['required', 'string'],
            'incident_date' => ['required', 'date'],
            'resolution' => ['nullable', 'string'],
            'delay_minutes' => ['nullable', 'integer', 'min:0'],
            'affects_budget' => ['nullable', 'boolean'],
            'affects_deadline' => ['nullable', 'boolean'],
            'status' => ['required', 'in:abierta,en_proceso,resuelta'],
        ]);

        $validated['affects_budget'] = $request->boolean('affects_budget');
        $validated['affects_deadline'] = $request->boolean('affects_deadline');

        $incident->update($validated);

        return redirect()->route('incidents.index')->with('success', 'Incidencia actualizada correctamente.');
    }

    public function destroy(Incident $incident)
    {
        $incident->delete();

        return redirect()->route('incidents.index')->with('success', 'Incidencia eliminada correctamente.');
    }
}