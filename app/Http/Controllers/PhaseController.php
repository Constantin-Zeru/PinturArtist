<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Material;
use App\Models\Phase;
use App\Models\User;
use Illuminate\Http\Request;

class PhaseController extends Controller
{
    public function index()
    {
        $phases = Phase::with(['job.client', 'responsibleUser', 'materials'])
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('phases.index', compact('phases'));
    }

    public function create()
    {
        $jobs = Job::with('client')->orderByDesc('created_at')->get();
        $users = User::orderBy('name')->get();
        $materials = Material::orderBy('name')->get();

        return view('phases.create', compact('jobs', 'users', 'materials'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'job_id' => ['required', 'exists:jobs,id'],
            'responsible_user_id' => ['nullable', 'exists:users,id'],
            'name' => ['required', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'status' => ['required', 'in:pendiente,en_proceso,completada'],
            'phase_date' => ['nullable', 'date'],
            'hours_spent' => ['nullable', 'numeric', 'min:0'],
            'observations' => ['nullable', 'string'],
            'requires_photo' => ['nullable', 'boolean'],
            'requires_video' => ['nullable', 'boolean'],
            'materials' => ['nullable', 'array'],
            'materials.*' => ['exists:materials,id'],
        ]);

        $validated['requires_photo'] = $request->boolean('requires_photo');
        $validated['requires_video'] = $request->boolean('requires_video');

        $materials = $validated['materials'] ?? [];
        unset($validated['materials']);

        $phase = Phase::create($validated);

        if (!empty($materials)) {
            $phase->materials()->sync($materials);
        }

        return redirect()->route('phases.index')->with('success', 'Fase creada correctamente.');
    }

    public function show(Phase $phase)
    {
        $phase->load(['job.client', 'responsibleUser', 'materials', 'galleryItems.uploadedBy', 'incidents']);

        return view('phases.show', compact('phase'));
    }

    public function edit(Phase $phase)
    {
        $jobs = Job::with('client')->orderByDesc('created_at')->get();
        $users = User::orderBy('name')->get();
        $materials = Material::orderBy('name')->get();

        return view('phases.edit', compact('phase', 'jobs', 'users', 'materials'));
    }

    public function update(Request $request, Phase $phase)
    {
        $validated = $request->validate([
            'job_id' => ['required', 'exists:jobs,id'],
            'responsible_user_id' => ['nullable', 'exists:users,id'],
            'name' => ['required', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'status' => ['required', 'in:pendiente,en_proceso,completada'],
            'phase_date' => ['nullable', 'date'],
            'hours_spent' => ['nullable', 'numeric', 'min:0'],
            'observations' => ['nullable', 'string'],
            'requires_photo' => ['nullable', 'boolean'],
            'requires_video' => ['nullable', 'boolean'],
            'materials' => ['nullable', 'array'],
            'materials.*' => ['exists:materials,id'],
        ]);

        $validated['requires_photo'] = $request->boolean('requires_photo');
        $validated['requires_video'] = $request->boolean('requires_video');

        $materials = $validated['materials'] ?? [];
        unset($validated['materials']);

        $phase->update($validated);
        $phase->materials()->sync($materials);

        return redirect()->route('phases.index')->with('success', 'Fase actualizada correctamente.');
    }

    public function destroy(Phase $phase)
    {
        $phase->delete();

        return redirect()->route('phases.index')->with('success', 'Fase eliminada correctamente.');
    }
}