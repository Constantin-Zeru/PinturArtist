@csrf

<div class="mb-3">
    <label class="form-label">Encargo</label>
    <select name="job_id" class="form-select" id="budget-job">
        <option value="">-- Selecciona --</option>
        @foreach($jobs as $job)
            <option value="{{ $job->id }}" {{ old('job_id', $budget->job_id ?? '') == $job->id ? 'selected' : '' }}>
                {{ $job->name }} - {{ $job->client?->name }} {{ $job->client?->surname }}
            </option>
        @endforeach
    </select>
    <div class="form-text">Selecciona el trabajo al que pertenece este presupuesto base.</div>
    @error('job_id') <div class="text-danger small">{{ $message }}</div> @enderror
</div>

<div class="row">
    <div class="col-md-4 mb-3">
        <label class="form-label">Tiempo estimado (h)</label>
        <input type="number" step="0.01" name="estimated_time_hours" id="estimated_time_hours"
               class="form-control" value="{{ old('estimated_time_hours', $budget->estimated_time_hours ?? 0) }}">
        <div class="form-text">Horas previstas antes de empezar.</div>
        @error('estimated_time_hours') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Horas reales de mano de obra</label>
        <input type="number" step="0.01" name="labor_hours" id="labor_hours"
               class="form-control" value="{{ old('labor_hours', $budget->labor_hours ?? 0) }}">
        <div class="form-text">Horas reales consumidas para calcular el coste base.</div>
        @error('labor_hours') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">IVA (%)</label>
        <input type="number" step="0.01" name="tax_rate" id="tax_rate"
               class="form-control" value="{{ old('tax_rate', $budget->tax_rate ?? 21) }}">
        <div class="form-text">Impuesto aplicado al total.</div>
        @error('tax_rate') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>
</div>

<div class="row">
    <div class="col-md-4 mb-3">
        <label class="form-label">Coste materiales</label>
        <input type="number" step="0.01" name="material_cost" id="material_cost"
               class="form-control" value="{{ old('material_cost', $budget->material_cost ?? 0) }}">
        <div class="form-text">Pintura, masilla, cinta, plásticos, etc.</div>
        @error('material_cost') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Descuento</label>
        <input type="number" step="0.01" name="discount_amount" id="discount_amount"
               class="form-control" value="{{ old('discount_amount', $budget->discount_amount ?? 0) }}">
        <div class="form-text">Descuento comercial aplicado al cliente.</div>
        @error('discount_amount') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Margen de beneficio (%)</label>
        <input type="number" step="0.01" name="profit_margin"
               class="form-control" value="{{ old('profit_margin', $budget->profit_margin ?? 0) }}">
        <div class="form-text">Margen interno del negocio. No se muestra al cliente.</div>
        @error('profit_margin') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>
</div>

<div class="row">
    <div class="col-md-4 mb-3">
        <label class="form-label">Total base estimado</label>
        <input type="text" id="estimated_total" class="form-control" readonly
               value="{{ old('estimated_total', $budget->estimated_total ?? 0) }}">
        <div class="form-text">Importe base antes de cambios aprobados.</div>
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Diferencia horas</label>
        <input type="text" id="time_difference_hours" class="form-control" readonly
               value="{{ old('time_difference_hours', $budget->time_difference_hours ?? 0) }}">
        <div class="form-text">Diferencia entre horas reales y estimadas.</div>
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Estado</label>
        @php($status = old('status', $budget->status ?? 'borrador'))
        <select name="status" class="form-select">
            <option value="borrador" {{ $status === 'borrador' ? 'selected' : '' }}>Borrador</option>
            <option value="enviado" {{ $status === 'enviado' ? 'selected' : '' }}>Enviado</option>
            <option value="aceptado" {{ $status === 'aceptado' ? 'selected' : '' }}>Aceptado</option>
            <option value="rechazado" {{ $status === 'rechazado' ? 'selected' : '' }}>Rechazado</option>
        </select>
        <div class="form-text">Estado del presupuesto base.</div>
        @error('status') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>
</div>

<div class="mb-3">
    <label class="form-label">Notas</label>
    <textarea name="notes" class="form-control" rows="4">{{ old('notes', $budget->notes ?? '') }}</textarea>
    <div class="form-text">Observaciones internas del presupuesto base.</div>
    @error('notes') <div class="text-danger small">{{ $message }}</div> @enderror
</div>

<button type="submit" class="btn btn-success">Guardar</button>
<a href="{{ route('budgets.index') }}" class="btn btn-secondary">Volver</a>

@push('scripts')
<script src="{{ asset('assets/js/budget.js') }}"></script>
@endpush