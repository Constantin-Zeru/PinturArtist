<?php

namespace App\Http\Controllers;

use App\Models\GalleryItem;
use App\Models\Job;
use App\Models\Phase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryItemController extends Controller
{
    public function index()
    {
       $items = GalleryItem::with(['job.client', 'phase', 'uploadedBy'])
        ->orderByDesc('created_at')
        ->paginate(12);

    $jobs = Job::orderBy('name')->get();
    $phases = Phase::orderBy('name')->get();

    return view('gallery.index', compact('items', 'jobs', 'phases'));
    }

    public function create()
    {
        $jobs = Job::with('client')->orderByDesc('created_at')->get();
        $phases = Phase::with('job.client')->orderByDesc('created_at')->get();

        return view('gallery.create', compact('jobs', 'phases'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'job_id' => ['required', 'exists:jobs,id'],
            'phase_id' => ['nullable', 'exists:phases,id'],
            'media_kind' => ['required', 'in:before,during,after,video'],
            'file' => ['required', 'file', 'mimes:jpg,jpeg,png,webp,mp4,mov,avi', 'max:51200'],
            'comment' => ['nullable', 'string'],
        ]);

        $file = $request->file('file');
        $path = $file->store('gallery', 'public');

        GalleryItem::create([
            'job_id' => $validated['job_id'],
            'phase_id' => $validated['phase_id'] ?? null,
            'uploaded_by' => auth()->id(),
            'media_kind' => $validated['media_kind'],
            'file_path' => $path,
            'file_name' => $file->getClientOriginalName(),
            'comment' => $validated['comment'] ?? null,
        ]);

        return redirect()->route('gallery.index')->with('success', 'Archivo subido correctamente.');
    }

    public function show(GalleryItem $gallery)
    {
        $gallery->load(['job.client', 'phase', 'uploadedBy']);

        return view('gallery.show', compact('gallery'));
    }

    public function edit(GalleryItem $gallery)
    {
        $jobs = Job::with('client')->orderByDesc('created_at')->get();
        $phases = Phase::with('job.client')->orderByDesc('created_at')->get();

        return view('gallery.edit', compact('gallery', 'jobs', 'phases'));
    }

    public function update(Request $request, GalleryItem $gallery)
    {
        $validated = $request->validate([
            'job_id' => ['required', 'exists:jobs,id'],
            'phase_id' => ['nullable', 'exists:phases,id'],
            'media_kind' => ['required', 'in:before,during,after,video'],
            'file' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,mp4,mov,avi', 'max:51200'],
            'comment' => ['nullable', 'string'],
        ]);

        if ($request->hasFile('file')) {
            if ($gallery->file_path) {
                Storage::disk('public')->delete($gallery->file_path);
            }

            $file = $request->file('file');
            $validated['file_path'] = $file->store('gallery', 'public');
            $validated['file_name'] = $file->getClientOriginalName();
        }

        $gallery->update([
            'job_id' => $validated['job_id'],
            'phase_id' => $validated['phase_id'] ?? null,
            'media_kind' => $validated['media_kind'],
            'file_path' => $validated['file_path'] ?? $gallery->file_path,
            'file_name' => $validated['file_name'] ?? $gallery->file_name,
            'comment' => $validated['comment'] ?? null,
        ]);

        return redirect()->route('gallery.index')->with('success', 'Archivo actualizado correctamente.');
    }

    public function destroy(GalleryItem $gallery)
    {
        if ($gallery->file_path) {
            Storage::disk('public')->delete($gallery->file_path);
        }

        $gallery->delete();

        return redirect()->route('gallery.index')->with('success', 'Archivo eliminado correctamente.');
    }
}