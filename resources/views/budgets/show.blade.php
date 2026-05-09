@extends('layouts.app')

@section('title', 'Ficha del presupuesto')

@section('content')
@php
    $isAdmin = auth()->user()->role === 'administrador';
@endphp

<div class="d-flex justify-content-between align-items-start mb-3 flex-wrap gap-2">
    <div>
        <h1 class="h3 mb-1">Ficha del presupuesto</h1>
        <p class="text-muted mb-0">Presupuesto base y modificaciones asociadas</p>
    </div>

    <div class="d-flex gap-2 flex-wrap">
        <a href="{{ route('budgets.pdf.base', $budget) }}" class="btn btn-outline-secondary">
            Descargar PDF base
        </a>

        <a href="{{ route('budgets.pdf.final', $budget) }}" class="btn btn-primary">
            Descargar PDF final
        </a>
    </div>
</div>

<div class="card shadow-sm mb-4">
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-6">
                <p class="mb-2"><strong>Encargo:</strong> {{ $budget->job?->name ?? '-' }}</p>
                <p class="mb-2"><strong>Cliente:</strong> {{ $budget->job?->client?->name }} {{ $budget->job?->client?->surname }}</p>
                <p class="mb-2"><strong>Estado:</strong> {{ ucfirst($budget->status) }}</p>
                <p class="mb-2"><strong>Total base:</strong> {{ number_format((float) $budget->estimated_total, 2) }} €</p>
                <p class="mb-2"><strong>Total final:</strong> {{ number_format((float) $budget->final_total, 2) }} €</p>
            </div>

            <div class="col-md-6">
                <p class="mb-2"><strong>Cambios aprobados:</strong> {{ number_format($budget->approved_changes_total, 2) }} €</p>
                <p class="mb-2"><strong>Total final calculado:</strong> {{ number_format($budget->calculated_final_total, 2) }} €</p>

                @if($isAdmin)
                    <p class="mb-2"><strong>Margen interno:</strong> {{ number_format((float) $budget->profit_margin, 2) }}%</p>
                    <p class="mb-2"><strong>Horas estimadas:</strong> {{ number_format((float) $budget->estimated_time_hours, 2) }}</p>
                    <p class="mb-2"><strong>Horas reales:</strong> {{ number_format((float) $budget->labor_hours, 2) }}</p>
                    <p class="mb-2"><strong>Diferencia horas:</strong> {{ number_format((float) $budget->time_difference_hours, 2) }}</p>
                @endif

                <p class="mb-0"><strong>Notas:</strong> {{ $budget->notes ?: '-' }}</p>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm mb-4">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
            <h2 class="h5 mb-0">Cambios aprobados / internos</h2>

            <div class="d-flex gap-2 flex-wrap">
                <span class="badge bg-success">Aprobado</span>
                <span class="badge bg-warning text-dark">Pendiente</span>
                <span class="badge bg-danger">Rechazado</span>
            </div>
        </div>

        @if($isAdmin)
            <form action="{{ route('budget-changes.store', $budget) }}" method="POST" class="mb-4">
                @csrf

                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Tipo</label>
                        <select name="kind" class="form-select">
                            @php($kind = old('kind', 'imprevisto'))
                            <option value="imprevisto" {{ $kind === 'imprevisto' ? 'selected' : '' }}>Imprevisto</option>
                            <option value="materiales" {{ $kind === 'materiales' ? 'selected' : '' }}>Materiales</option>
                            <option value="desplazamiento" {{ $kind === 'desplazamiento' ? 'selected' : '' }}>Desplazamiento</option>
                            <option value="urgencia" {{ $kind === 'urgencia' ? 'selected' : '' }}>Urgencia</option>
                            <option value="recargo" {{ $kind === 'recargo' ? 'selected' : '' }}>Recargo</option>
                            <option value="descuento" {{ $kind === 'descuento' ? 'selected' : '' }}>Descuento</option>
                            <option value="beneficio" {{ $kind === 'beneficio' ? 'selected' : '' }}>Beneficio</option>
                            <option value="otro" {{ $kind === 'otro' ? 'selected' : '' }}>Otro</option>
                        </select>
                        @error('kind') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-5 mb-3">
                        <label class="form-label">Descripción</label>
                        <input
                            type="text"
                            name="description"
                            class="form-control"
                            value="{{ old('description') }}"
                            placeholder="Ej: pintura extra, reparación, desplazamiento..."
                        >
                        @error('description') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-2 mb-3">
                        <label class="form-label">Importe</label>
                        <input
                            type="number"
                            step="0.01"
                            name="amount"
                            class="form-control"
                            value="{{ old('amount', 0) }}"
                        >
                        @error('amount') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-2 mb-3">
                        <label class="form-label">Estado</label>
                        @php($changeStatus = old('status', 'aprobado'))
                        <select name="status" class="form-select">
                            <option value="pendiente" {{ $changeStatus === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                            <option value="aprobado" {{ $changeStatus === 'aprobado' ? 'selected' : '' }}>Aprobado</option>
                            <option value="rechazado" {{ $changeStatus === 'rechazado' ? 'selected' : '' }}>Rechazado</option>
                        </select>
                        @error('status') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="form-check mb-3">
                    <input
                        class="form-check-input"
                        type="checkbox"
                        name="visible_to_customer"
                        value="1"
                        id="visible_to_customer"
                        {{ old('visible_to_customer') ? 'checked' : '' }}
                    >
                    <label class="form-check-label" for="visible_to_customer">
                        Visible para el cliente
                    </label>
                    @error('visible_to_customer') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>

                <button class="btn btn-primary">Añadir cambio</button>
            </form>
        @endif

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Tipo</th>
                        <th>Descripción</th>
                        <th>Importe</th>
                        <th>Estado</th>
                        <th>Visible al cliente</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($budget->changes as $change)
                        <tr>
                            <td>{{ ucfirst($change->kind) }}</td>
                            <td>{{ $change->description }}</td>
                            <td class="{{ (float) $change->amount < 0 ? 'text-danger' : 'text-success' }}">
                                {{ number_format((float) $change->amount, 2) }} €
                            </td>
                            <td>
                                @if($change->status === 'aprobado')
                                    <span class="badge bg-success">Aprobado</span>
                                @elseif($change->status === 'pendiente')
                                    <span class="badge bg-warning text-dark">Pendiente</span>
                                @else
                                    <span class="badge bg-danger">Rechazado</span>
                                @endif
                            </td>
                            <td>{{ $change->visible_to_customer ? 'Sí' : 'No' }}</td>
                            <td class="text-end">
                                @if($isAdmin)
                                    <form action="{{ route('budget-changes.destroy', $change) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar este cambio?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">Borrar</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">No hay cambios todavía.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            <strong>Total cambios aprobados:</strong> {{ number_format($budget->approved_changes_total, 2) }} €
        </div>
    </div>
</div>

<div class="card shadow-sm mb-4">
    <div class="card-body">
        <h2 class="h5 mb-3">Enviar presupuesto por correo</h2>

        <form action="{{ route('budgets.pdf.send', $budget) }}" method="POST" class="row g-2 align-items-end">
            @csrf

            <div class="col-md-9">
                <label class="form-label">Correo del cliente</label>
                <input
                    type="email"
                    name="email"
                    class="form-control"
                    placeholder="correo@cliente.com"
                    value="{{ old('email', $budget->job?->client?->email) }}"
                >
                @error('email') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-3">
                <button class="btn btn-success w-100">
                    Enviar PDF final
                </button>
            </div>
        </form>
    </div>
</div>

<a href="{{ route('budgets.index') }}" class="btn btn-secondary">Volver</a>
@endsection