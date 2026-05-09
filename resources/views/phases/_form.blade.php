@csrf

<div class="mb-3">
    <label class="form-label">Encargo</label>
    <select name="job_id" class="form-select">
        <option value="">-- Selecciona --</option>
        @foreach($jobs as $job)
            <option value="{{ $job->id }}" {{ old('job_id', $phase->job_id ?? '') == $job->id ? 'selected' : '' }}>
                {{ $job->name }} - {{ $job->client?->name }} {{ $job->client?->surname }}
            </option>
        @endforeach
    </select>
    @error('job_id') <div class="text-danger small">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Responsable</label>
    <select name="responsible_user_id" class="form-select">
        <option value="">-- Sin asignar --</option>
        @foreach($users as $user)
            <option value="{{ $user->id }}" {{ old('responsible_user_id', $phase->responsible_user_id ?? '') == $user->id ? 'selected' : '' }}>
                {{ $user->name }} {{ $user->surname }} ({{ $user->role }})
            </option>
        @endforeach
    </select>
    @error('responsible_user_id') <div class="text-danger small">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Nombre de la fase</label>
    <select name="name" class="form-select">
        @php($phaseName = old('name', $phase->name ?? ''))
        <option value="">-- Selecciona --</option>
        <option value="preparación" {{ $phaseName === 'preparación' ? 'selected' : '' }}>Preparación</option>
        <option value="protección de la zona" {{ $phaseName === 'protección de la zona' ? 'selected' : '' }}>Protección de la zona</option>
        <option value="tapar huecos" {{ $phaseName === 'tapar huecos' ? 'selected' : '' }}>Tapar huecos</option>
        <option value="reparación de desperfectos" {{ $phaseName === 'reparación de desperfectos' ? 'selected' : '' }}>Reparación de desperfectos</option>
        <option value="lijado" {{ $phaseName === 'lijado' ? 'selected' : '' }}>Lijado</option>
        <option value="imprimación" {{ $phaseName === 'imprimación' ? 'selected' : '' }}>Imprimación</option>
        <option value="primera mano" {{ $phaseName === 'primera mano' ? 'selected' : '' }}>Primera mano</option>
        <option value="segunda mano" {{ $phaseName === 'segunda mano' ? 'selected' : '' }}>Segunda mano</option>
        <option value="retoques" {{ $phaseName === 'retoques' ? 'selected' : '' }}>Retoques</option>
        <option value="limpieza final" {{ $phaseName === 'limpieza final' ? 'selected' : '' }}>Limpieza final</option>
        <option value="entrega" {{ $phaseName === 'entrega' ? 'selected' : '' }}>Entrega</option>
    </select>
    @error('name') <div class="text-danger small">{{ $message }}</div> @enderror
</div>

<div class="row">
    <div class="col-md-4 mb-3">
        <label class="form-label">Orden</label>
        <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $phase->sort_order ?? 0) }}">
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Estado</label>
        @php($status = old('status', $phase->status ?? 'pendiente'))
        <select name="status" class="form-select">
            <option value="pendiente" {{ $status === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
            <option value="en_proceso" {{ $status === 'en_proceso' ? 'selected' : '' }}>En proceso</option>
            <option value="completada" {{ $status === 'completada' ? 'selected' : '' }}>Completada</option>
        </select>
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Fecha</label>
        <input type="date" name="phase_date" class="form-control" value="{{ old('phase_date', isset($phase->phase_date) ? $phase->phase_date->format('Y-m-d') : '') }}">
    </div>
</div>

<div class="row">
    <div class="col-md-4 mb-3">
        <label class="form-label">Horas empleadas</label>
        <input type="number" step="0.01" name="hours_spent" class="form-control" value="{{ old('hours_spent', $phase->hours_spent ?? '') }}">
    </div>

    <div class="col-md-4 mb-3 d-flex align-items-end">
        <div class="form-check me-3">
            <input class="form-check-input" type="checkbox" name="requires_photo" value="1" {{ old('requires_photo', $phase->requires_photo ?? true) ? 'checked' : '' }}>
            <label class="form-check-label">Requiere foto</label>
        </div>
    </div>

    <div class="col-md-4 mb-3 d-flex align-items-end">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="requires_video" value="1" {{ old('requires_video', $phase->requires_video ?? true) ? 'checked' : '' }}>
            <label class="form-check-label">Requiere vídeo</label>
        </div>
    </div>
</div>

<div class="mb-3">
    <label class="form-label">Materiales usados</label>
    <select name="materials[]" class="form-select" multiple size="6">
        @php($selectedMaterials = old('materials', isset($phase) ? $phase->materials->pluck('id')->toArray() : []))
        @foreach($materials as $material)
            <option value="{{ $material->id }}" {{ in_array($material->id, $selectedMaterials ?? []) ? 'selected' : '' }}>
                {{ $material->name }} ({{ $material->unit_measurement }})
            </option>
        @endforeach
    </select>
    @error('materials') <div class="text-danger small">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Observaciones</label>
    <textarea name="observations" class="form-control" rows="4">{{ old('observations', $phase->observations ?? '') }}</textarea>
</div>

<button type="submit" class="btn btn-success">Guardar</button>
<a href="{{ route('phases.index') }}" class="btn btn-secondary">Volver</a>