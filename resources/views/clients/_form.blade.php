@csrf

<div class="mb-3">
    <label class="form-label">Nombre</label>
    <input type="text" name="name" class="form-control" value="{{ old('name', $client->name ?? '') }}">
    @error('name') <div class="text-danger small">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Apellidos</label>
    <input type="text" name="surname" class="form-control" value="{{ old('surname', $client->surname ?? '') }}">
    @error('surname') <div class="text-danger small">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">DNI / NIF</label>
    <input type="text" name="dni_nif" class="form-control" value="{{ old('dni_nif', $client->dni_nif ?? '') }}">
    @error('dni_nif') <div class="text-danger small">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Teléfono</label>
    <input type="text" name="phone" class="form-control" value="{{ old('phone', $client->phone ?? '') }}">
    @error('phone') <div class="text-danger small">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Email</label>
    <input type="email" name="email" class="form-control" value="{{ old('email', $client->email ?? '') }}">
    @error('email') <div class="text-danger small">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Dirección completa</label>
    <textarea name="full_address" class="form-control" rows="3">{{ old('full_address', $client->full_address ?? '') }}</textarea>
    @error('full_address') <div class="text-danger small">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Tipo de cliente</label>
    @php($type = old('client_type', $client->client_type ?? ''))
    <select name="client_type" class="form-select">
        <option value="">-- Selecciona --</option>
        <option value="particular" {{ $type === 'particular' ? 'selected' : '' }}>Particular</option>
        <option value="empresa" {{ $type === 'empresa' ? 'selected' : '' }}>Empresa</option>
        <option value="comunidad" {{ $type === 'comunidad' ? 'selected' : '' }}>Comunidad</option>
    </select>
    @error('client_type') <div class="text-danger small">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Notas internas</label>
    <textarea name="internal_notes" class="form-control" rows="4">{{ old('internal_notes', $client->internal_notes ?? '') }}</textarea>
    @error('internal_notes') <div class="text-danger small">{{ $message }}</div> @enderror
</div>

<button type="submit" class="btn btn-success">Guardar</button>
<a href="{{ route('clients.index') }}" class="btn btn-secondary">Volver</a>