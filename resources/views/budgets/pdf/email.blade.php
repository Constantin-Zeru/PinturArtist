<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Presupuesto #{{ $budget->id }}</title>
    <style>
        @page {
            margin: 28px 28px 36px 28px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #1f2937;
            line-height: 1.5;
        }

        .header {
            width: 100%;
            margin-bottom: 18px;
            border-bottom: 2px solid #111827;
            padding-bottom: 12px;
        }

        .header-table {
            width: 100%;
        }

        .brand {
            font-size: 20px;
            font-weight: bold;
            color: #111827;
        }

        .subtitle {
            font-size: 11px;
            color: #6b7280;
            margin-top: 2px;
        }

        .meta {
            text-align: right;
            font-size: 11px;
            color: #6b7280;
        }

        .section {
            margin-bottom: 16px;
            padding: 14px;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
        }

        .section-title {
            font-size: 13px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #111827;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 6px;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
        }

        .info-table td {
            padding: 5px 0;
            vertical-align: top;
        }

        .label {
            color: #6b7280;
            width: 40%;
        }

        .value {
            font-weight: 600;
            color: #111827;
        }

        .totals {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }

        .totals td {
            padding: 8px 10px;
            border: 1px solid #e5e7eb;
        }

        .totals .total-label {
            background: #f9fafb;
            width: 70%;
            font-weight: 600;
        }

        .totals .total-value {
            text-align: right;
            font-weight: 700;
        }

        .highlight {
            background: #eff6ff;
        }

        .danger {
            background: #fef2f2;
        }

        .success {
            background: #ecfdf5;
        }

        .warning {
            background: #fffbeb;
        }

        .muted {
            color: #6b7280;
        }

        .notes {
            white-space: pre-wrap;
        }

        .footer {
            margin-top: 24px;
            padding-top: 10px;
            border-top: 1px solid #e5e7eb;
            font-size: 10px;
            color: #6b7280;
            text-align: center;
        }

        .changes-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }

        .changes-table th,
        .changes-table td {
            border: 1px solid #e5e7eb;
            padding: 7px 8px;
            vertical-align: top;
        }

        .changes-table th {
            background: #f9fafb;
            text-align: left;
            font-weight: 700;
        }

        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 999px;
            font-size: 10px;
            font-weight: 700;
        }

        .badge-success {
            background: #dcfce7;
            color: #166534;
        }

        .badge-warning {
            background: #fef3c7;
            color: #92400e;
        }

        .badge-danger {
            background: #fee2e2;
            color: #991b1b;
        }
    </style>
</head>
<body>

@php
    $clientName = trim(($budget->job?->client?->name ?? '') . ' ' . ($budget->job?->client?->surname ?? ''));
    $jobName = $budget->job?->name ?? '-';
@endphp

<div class="header">
    <table class="header-table">
        <tr>
            <td>
                <div class="brand">Presupuesto</div>
                <div class="subtitle">Base + final + cambios aplicados</div>
            </td>
            <td class="meta">
                <div><strong>Nº:</strong> {{ $budget->id }}</div>
                <div><strong>Fecha:</strong> {{ now()->format('d/m/Y H:i') }}</div>
            </td>
        </tr>
    </table>
</div>

<div class="section">
    <div class="section-title">Datos del encargo</div>
    <table class="info-table">
        <tr>
            <td class="label">Encargo</td>
            <td class="value">{{ $jobName }}</td>
        </tr>
        <tr>
            <td class="label">Cliente</td>
            <td class="value">{{ $clientName ?: '-' }}</td>
        </tr>
        <tr>
            <td class="label">Estado</td>
            <td class="value">{{ ucfirst($budget->status) }}</td>
        </tr>
    </table>
</div>

<div class="section">
    <div class="section-title">Presupuesto base</div>
    <table class="totals">
        <tr>
            <td class="total-label">Horas estimadas</td>
            <td class="total-value">{{ number_format((float) $budget->estimated_time_hours, 2, ',', '.') }} h</td>
        </tr>
        <tr>
            <td class="total-label">Horas reales</td>
            <td class="total-value">{{ number_format((float) $budget->labor_hours, 2, ',', '.') }} h</td>
        </tr>
        <tr>
            <td class="total-label">Diferencia</td>
            <td class="total-value">{{ number_format((float) $budget->time_difference_hours, 2, ',', '.') }} h</td>
        </tr>
        <tr>
            <td class="total-label">Coste materiales</td>
            <td class="total-value">{{ number_format((float) $budget->material_cost, 2, ',', '.') }} €</td>
        </tr>
        <tr>
            <td class="total-label">Descuento</td>
            <td class="total-value">- {{ number_format((float) $budget->discount_amount, 2, ',', '.') }} €</td>
        </tr>
        <tr>
            <td class="total-label">IVA</td>
            <td class="total-value">{{ number_format((float) $budget->tax_rate, 2, ',', '.') }} %</td>
        </tr>
        <tr>
            <td class="total-label">Total base estimado</td>
            <td class="total-value">{{ number_format((float) $baseTotal, 2, ',', '.') }} €</td>
        </tr>
    </table>
</div>

<div class="section">
    <div class="section-title">Presupuesto final</div>
    <table class="totals">
        <tr class="success">
            <td class="total-label">Cambios aprobados</td>
            <td class="total-value">{{ number_format((float) $approvedTotal, 2, ',', '.') }} €</td>
        </tr>
        <tr class="warning">
            <td class="total-label">Cambios pendientes</td>
            <td class="total-value">{{ number_format((float) $pendingTotal, 2, ',', '.') }} €</td>
        </tr>
        <tr class="danger">
            <td class="total-label">Cambios rechazados</td>
            <td class="total-value">{{ number_format((float) $rejectedTotal, 2, ',', '.') }} €</td>
        </tr>
        <tr class="highlight">
            <td class="total-label">Total final</td>
            <td class="total-value">{{ number_format((float) $finalTotal, 2, ',', '.') }} €</td>
        </tr>
    </table>
</div>

<div class="section">
    <div class="section-title">Detalle de modificaciones</div>

    <table class="changes-table">
        <thead>
            <tr>
                <th style="width: 12%;">Tipo</th>
                <th>Descripción</th>
                <th style="width: 12%;">Importe</th>
                <th style="width: 12%;">Estado</th>
                <th style="width: 12%;">Visible</th>
            </tr>
        </thead>
        <tbody>
            @forelse($changes as $change)
                <tr>
                    <td>{{ ucfirst($change->kind) }}</td>
                    <td>{{ $change->description }}</td>
                    <td>{{ number_format((float) $change->amount, 2, ',', '.') }} €</td>
                    <td>
                        @if($change->status === 'aprobado')
                            <span class="badge badge-success">Aprobado</span>
                        @elseif($change->status === 'pendiente')
                            <span class="badge badge-warning">Pendiente</span>
                        @else
                            <span class="badge badge-danger">Rechazado</span>
                        @endif
                    </td>
                    <td>{{ $change->visible_to_customer ? 'Sí' : 'No' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="muted">No hay modificaciones registradas.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($budget->notes)
    <div class="section">
        <div class="section-title">Notas</div>
        <div class="notes">{{ $budget->notes }}</div>
    </div>
@endif

<div class="footer">
    Documento generado automáticamente por el sistema de presupuestos.
</div>

</body>
</html>