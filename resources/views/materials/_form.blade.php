@csrf

<div class="mb-3">
    <label class="form-label">Nombre</label>
    <input type="text" name="name" class="form-control" value="{{ old('name', $material->name ?? '') }}">
    @error('name') <div class="text-danger small">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Unidad de medida</label>
    <input type="text" name="unit_measurement" class="form-control" value="{{ old('unit_measurement', $material->unit_measurement ?? '') }}">
    @error('unit_measurement') <div class="text-danger small">{{ $message }}</div> @enderror
</div>

<div class="row">
    <div class="col-md-4 mb-3">
        <label class="form-label">Cantidad disponible</label>
        <input type="number" step="0.01" name="available_quantity" class="form-control" value="{{ old('available_quantity', $material->available_quantity ?? '') }}">
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">Coste</label>
        <input type="number" step="0.01" name="cost" class="form-control" value="{{ old('cost', $material->cost ?? '') }}">
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">Proveedor</label>
        <input type="text" name="provider" class="form-control" value="{{ old('provider', $material->provider ?? '') }}">
    </div>
</div>

<div class="mb-3">
    <label class="form-label">Notas</label>
    <textarea name="notes" class="form-control" rows="4">{{ old('notes', $material->notes ?? '') }}</textarea>
</div>

<div class="form-check mb-3">
    <input class="form-check-input" type="checkbox" name="active" value="1" {{ old('active', $material->active ?? true) ? 'checked' : '' }}>
    <label class="form-check-label">Activo</label>
</div>

<button type="submit" class="btn btn-success">Guardar</button>
<a href="{{ route('materials.index') }}" class="btn btn-secondary">Volver</a>