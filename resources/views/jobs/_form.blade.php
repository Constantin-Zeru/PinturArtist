@csrf

<div class="mb-3">
    <label class="form-label">Cliente</label>
    <select name="client_id" class="form-select">
        <option value="">-- Selecciona --</option>
        @foreach($clients as $client)
            <option value="{{ $client->id }}" {{ old('client_id', $job->client_id ?? '') == $client->id ? 'selected' : '' }}>
                {{ $client->name }} {{ $client->surname }}
            </option>
        @endforeach
    </select>
    <div class="form-text">Selecciona el cliente al que pertenece el encargo.</div>
    @error('client_id') <div class="text-danger small">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Nombre del encargo</label>
    <input type="text" name="name" class="form-control" value="{{ old('name', $job->name ?? '') }}">
    <div class="form-text">Nombre corto y claro del trabajo a realizar.</div>
    @error('name') <div class="text-danger small">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Tipo de trabajo</label>
    <input type="text" name="work_type" class="form-control" value="{{ old('work_type', $job->work_type ?? '') }}" placeholder="Interior, exterior, fachada...">
    <div class="form-text">Define si es interior, exterior, fachada, local, vivienda, etc.</div>
    @error('work_type') <div class="text-danger small">{{ $message }}</div> @enderror
</div>

<div class="row">
    <div class="col-md-4 mb-3">
        <label class="form-label">Estado técnico</label>
        @php($technicalState = old('technical_state', $job->technical_state ?? 'nuevo'))
        <select name="technical_state" class="form-select">
            <option value="nuevo" {{ $technicalState === 'nuevo' ? 'selected' : '' }}>Nuevo</option>
            <option value="regular" {{ $technicalState === 'regular' ? 'selected' : '' }}>Regular</option>
            <option value="malo" {{ $technicalState === 'malo' ? 'selected' : '' }}>Malo</option>
        </select>
        <div class="form-text">Estado visual o técnico actual del trabajo.</div>
        @error('technical_state') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Estado</label>
        @php($status = old('status', $job->status ?? 'pendiente'))
        <select name="status" class="form-select">
            <option value="pendiente" {{ $status === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
            <option value="aceptado" {{ $status === 'aceptado' ? 'selected' : '' }}>Aceptado</option>
            <option value="en_proceso" {{ $status === 'en_proceso' ? 'selected' : '' }}>En proceso</option>
            <option value="pausado" {{ $status === 'pausado' ? 'selected' : '' }}>Pausado</option>
            <option value="finalizado" {{ $status === 'finalizado' ? 'selected' : '' }}>Finalizado</option>
            <option value="cancelado" {{ $status === 'cancelado' ? 'selected' : '' }}>Cancelado</option>
        </select>
        <div class="form-text">Estado de gestión del encargo.</div>
        @error('status') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Prioridad</label>
        @php($priority = old('priority', $job->priority ?? 'media'))
        <select name="priority" class="form-select">
            <option value="baja" {{ $priority === 'baja' ? 'selected' : '' }}>Baja</option>
            <option value="media" {{ $priority === 'media' ? 'selected' : '' }}>Media</option>
            <option value="alta" {{ $priority === 'alta' ? 'selected' : '' }}>Alta</option>
        </select>
        <div class="form-text">Nivel de urgencia del trabajo.</div>
        @error('priority') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>
</div>

<div class="mb-3">
    <label class="form-label">Trabajadores asignados</label>
    <select name="worker_ids[]" class="form-select" multiple size="5">
        @php($selectedWorkers = old('worker_ids', isset($job) ? $job->users->pluck('id')->toArray() : []))

        @foreach($workers as $worker)
            <option value="{{ $worker->id }}" {{ in_array($worker->id, $selectedWorkers ?? []) ? 'selected' : '' }}>
                {{ $worker->name }} {{ $worker->surname }}
            </option>
        @endforeach
    </select>
    <div class="form-text">Selecciona uno o varios trabajadores para este encargo.</div>
    @error('worker_ids') <div class="text-danger small">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Descripción</label>
    <textarea name="description" class="form-control" rows="3">{{ old('description', $job->description ?? '') }}</textarea>
    <div class="form-text">Descripción general del encargo.</div>
    @error('description') <div class="text-danger small">{{ $message }}</div> @enderror
</div>

<div class="row">
    <div class="col-md-4 mb-3">
        <label class="form-label">Superficie aproximada (m²)</label>
        <input type="number" step="0.01" name="surface_m2" class="form-control" value="{{ old('surface_m2', $job->surface_m2 ?? '') }}">
        <div class="form-text">Metros cuadrados aproximados a pintar.</div>
        @error('surface_m2') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Número de estancias</label>
        <input type="number" name="rooms_count" class="form-control" value="{{ old('rooms_count', $job->rooms_count ?? '') }}">
        <div class="form-text">Habitaciones, estancias o zonas afectadas.</div>
        @error('rooms_count') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Altura media (m)</label>
        <input type="number" step="0.01" name="height_m" class="form-control" value="{{ old('height_m', $job->height_m ?? '') }}">
        <div class="form-text">Altura aproximada de la zona a trabajar.</div>
        @error('height_m') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>
</div>

<div class="row">
    <div class="col-md-4 mb-3">
        <label class="form-label">Fecha de solicitud</label>
        <input type="date" name="requested_at" class="form-control" value="{{ old('requested_at', isset($job->requested_at) ? $job->requested_at->format('Y-m-d') : '') }}">
        <div class="form-text">Fecha en la que se recibió el encargo.</div>
        @error('requested_at') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Inicio previsto</label>
        <input type="date" name="planned_start_at" class="form-control" value="{{ old('planned_start_at', isset($job->planned_start_at) ? $job->planned_start_at->format('Y-m-d') : '') }}">
        <div class="form-text">Fecha estimada para empezar el trabajo.</div>
        @error('planned_start_at') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Fin previsto</label>
        <input type="date" name="planned_end_at" class="form-control" value="{{ old('planned_end_at', isset($job->planned_end_at) ? $job->planned_end_at->format('Y-m-d') : '') }}">
        <div class="form-text">Fecha estimada para finalizar el trabajo.</div>
        @error('planned_end_at') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>
</div>

<div class="mb-3">
    <label class="form-label">Observaciones técnicas</label>
    <textarea name="technical_observations" class="form-control" rows="4">{{ old('technical_observations', $job->technical_observations ?? '') }}</textarea>
    <div class="form-text">Notas internas: humedades, grietas, reparaciones, etc.</div>
    @error('technical_observations') <div class="text-danger small">{{ $message }}</div> @enderror
</div>

<button type="submit" class="btn btn-success">Guardar</button>
<a href="{{ route('jobs.index') }}" class="btn btn-secondary">Volver</a>