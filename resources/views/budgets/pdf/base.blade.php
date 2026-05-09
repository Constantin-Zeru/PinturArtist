<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Presupuesto base #{{ $budget->id }}</title>
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

        .two-col {
            width: 100%;
            border-collapse: collapse;
        }

        .two-col td {
            vertical-align: top;
            width: 50%;
            padding-right: 10px;
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

        .muted {
            color: #6b7280;
        }

        .text-right {
            text-align: right;
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
                <div class="brand">Presupuesto base</div>
                <div class="subtitle">Documento interno y para cliente</div>
            </td>
            <td class="meta">
                <div><strong>Nº:</strong> {{ $budget->id }}</div>
                <div><strong>Fecha:</strong> {{ now()->format('d/m/Y H:i') }}</div>
            </td>
        </tr>
    </table>
</div>

@if($showInternal)
    <p><strong>Margen interno:</strong> {{ $budget->profit_margin }}%</p>
@endif

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
    <div class="section-title">Cálculo del presupuesto base</div>

    <table class="two-col">
        <tr>
            <td>
                <table class="info-table">
                    <tr>
                        <td class="label">Horas estimadas</td>
                        <td class="value">{{ number_format((float) $budget->estimated_time_hours, 2, ',', '.') }} h</td>
                    </tr>
                    <tr>
                        <td class="label">Horas reales</td>
                        <td class="value">{{ number_format((float) $budget->labor_hours, 2, ',', '.') }} h</td>
                    </tr>
                    <tr>
                        <td class="label">Diferencia</td>
                        <td class="value">{{ number_format((float) $budget->time_difference_hours, 2, ',', '.') }} h</td>
                    </tr>
                </table>
            </td>
            <td>
                <table class="info-table">
                    <tr>
                        <td class="label">Coste materiales</td>
                        <td class="value">{{ number_format((float) $budget->material_cost, 2, ',', '.') }} €</td>
                    </tr>
                    <tr>
                        <td class="label">Descuento</td>
                        <td class="value">- {{ number_format((float) $budget->discount_amount, 2, ',', '.') }} €</td>
                    </tr>
                    <tr>
                        <td class="label">IVA</td>
                        <td class="value">{{ number_format((float) $budget->tax_rate, 2, ',', '.') }} %</td>
                    </tr>
                    <tr>
                        <td class="label">Margen interno</td>
                        <td class="value">{{ number_format((float) $budget->profit_margin, 2, ',', '.') }} %</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>

<div class="section">
    <div class="section-title">Importes</div>
    <table class="totals">
        <tr>
            <td class="total-label">Subtotal base</td>
            <td class="total-value">
                {{ number_format(((float) $budget->estimated_total / (1 + ((float) $budget->tax_rate / 100))), 2) }} €
            </td>
        </tr>
        <tr>
            <td class="total-label">Total estimado</td>
            <td class="total-value">{{ number_format((float) $budget->estimated_total, 2, ',', '.') }} €</td>
        </tr>
        <tr class="highlight">
            <td class="total-label">Total final</td>
            <td class="total-value">{{ number_format((float) $budget->final_total, 2, ',', '.') }} €</td>
        </tr>
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