@csrf

@php
    $selectedJobId = old('job_id', $incident->job_id ?? '');
    $selectedPhaseId = old('phase_id', $incident->phase_id ?? '');
    $status = old('status', $incident->status ?? 'abierta');
@endphp

<div class="mb-3">
    <label class="form-label">Encargo</label>
    <select name="job_id" class="form-select" id="job_id">
        <option value="">-- Selecciona --</option>
        @foreach($jobs as $job)
            <option value="{{ $job->id }}" {{ (string) $selectedJobId === (string) $job->id ? 'selected' : '' }}>
                {{ $job->name }} - {{ $job->client?->name }} {{ $job->client?->surname }}
            </option>
        @endforeach
    </select>
    @error('job_id') <div class="text-danger small">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Fase relacionada</label>
    <select
        name="phase_id"
        class="form-select"
        id="phase_id"
        data-selected-phase="{{ $selectedPhaseId }}"
    >
        <option value="">-- Ninguna --</option>
    </select>
    <div class="form-text">Se cargan solo las fases del encargo seleccionado.</div>
    @error('phase_id') <div class="text-danger small">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Causa</label>
    <textarea name="cause" class="form-control" rows="3">{{ old('cause', $incident->cause ?? '') }}</textarea>
    @error('cause') <div class="text-danger small">{{ $message }}</div> @enderror
</div>

<div class="row">
    <div class="col-md-4 mb-3">
        <label class="form-label">Fecha</label>
        <input
            type="date"
            name="incident_date"
            class="form-control"
            value="{{ old('incident_date', isset($incident->incident_date) ? $incident->incident_date->format('Y-m-d') : '') }}"
        >
        @error('incident_date') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Retraso (minutos)</label>
        <input type="number" name="delay_minutes" class="form-control" value="{{ old('delay_minutes', $incident->delay_minutes ?? '') }}">
        @error('delay_minutes') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Estado</label>
        <select name="status" class="form-select">
            <option value="abierta" {{ $status === 'abierta' ? 'selected' : '' }}>Abierta</option>
            <option value="en_proceso" {{ $status === 'en_proceso' ? 'selected' : '' }}>En proceso</option>
            <option value="resuelta" {{ $status === 'resuelta' ? 'selected' : '' }}>Resuelta</option>
        </select>
        @error('status') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>
</div>

<div class="mb-3">
    <label class="form-label">Solución</label>
    <textarea name="resolution" class="form-control" rows="4">{{ old('resolution', $incident->resolution ?? '') }}</textarea>
    @error('resolution') <div class="text-danger small">{{ $message }}</div> @enderror
</div>

<div class="form-check mb-2">
    <input class="form-check-input" type="checkbox" name="affects_budget" value="1" {{ old('affects_budget', $incident->affects_budget ?? false) ? 'checked' : '' }}>
    <label class="form-check-label">Afecta al presupuesto</label>
    @error('affects_budget') <div class="text-danger small">{{ $message }}</div> @enderror
</div>

<div class="form-check mb-3">
    <input class="form-check-input" type="checkbox" name="affects_deadline" value="1" {{ old('affects_deadline', $incident->affects_deadline ?? false) ? 'checked' : '' }}>
    <label class="form-check-label">Afecta a la fecha final</label>
    @error('affects_deadline') <div class="text-danger small">{{ $message }}</div> @enderror
</div>

<button type="submit" class="btn btn-success">Guardar</button>
<a href="{{ route('incidents.index') }}" class="btn btn-secondary">Volver</a>

@push('scripts')
    <script src="{{ asset('assets/js/gallery.js') }}"></script>
@endpush