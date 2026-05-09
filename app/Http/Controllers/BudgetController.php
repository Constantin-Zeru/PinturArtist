<?php

namespace App\Http\Controllers;

use App\Mail\BudgetPdfMail;
use App\Models\Budget;
use App\Models\Job;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class BudgetController extends Controller
{
    private const LABOR_RATE = 20.0;

    public function index()
    {
        $budgets = Budget::with('job.client')
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('budgets.index', compact('budgets'));
    }

    public function create()
    {
        abort_unless(auth()->user()->role === 'administrador', 403);

        $jobs = Job::with('client')->orderByDesc('created_at')->get();

        return view('budgets.create', compact('jobs'));
    }

    public function store(Request $request)
    {
        abort_unless(auth()->user()->role === 'administrador', 403);

        $validated = $request->validate([
            'job_id' => ['required', 'exists:jobs,id', 'unique:budgets,job_id'],
            'estimated_time_hours' => ['nullable', 'numeric', 'min:0'],
            'labor_hours' => ['nullable', 'numeric', 'min:0'],
            'material_cost' => ['required', 'numeric', 'min:0'],
            'discount_amount' => ['required', 'numeric', 'min:0'],
            'tax_rate' => ['required', 'numeric', 'min:0'],
            'profit_margin' => ['required', 'numeric', 'min:0'],
            'status' => ['required', 'in:borrador,enviado,aceptado,rechazado'],
            'notes' => ['nullable', 'string'],
        ]);

        $validated = array_merge($validated, $this->calculateBaseBudget($validated));

        Budget::create($validated);

        return redirect()->route('budgets.index')->with('success', 'Presupuesto base creado correctamente.');
    }

    public function show(Budget $budget)
    {
        $budget->load([
            'job.client',
            'changes.createdBy',
        ]);

        return view('budgets.show', compact('budget'));
    }

    public function edit(Budget $budget)
    {
        abort_unless(auth()->user()->role === 'administrador', 403);

        $jobs = Job::with('client')->orderByDesc('created_at')->get();

        return view('budgets.edit', compact('budget', 'jobs'));
    }

    public function update(Request $request, Budget $budget)
    {
        abort_unless(auth()->user()->role === 'administrador', 403);

        $validated = $request->validate([
            'job_id' => ['required', 'exists:jobs,id', 'unique:budgets,job_id,' . $budget->id],
            'estimated_time_hours' => ['nullable', 'numeric', 'min:0'],
            'labor_hours' => ['nullable', 'numeric', 'min:0'],
            'material_cost' => ['required', 'numeric', 'min:0'],
            'discount_amount' => ['required', 'numeric', 'min:0'],
            'tax_rate' => ['required', 'numeric', 'min:0'],
            'profit_margin' => ['required', 'numeric', 'min:0'],
            'status' => ['required', 'in:borrador,enviado,aceptado,rechazado'],
            'notes' => ['nullable', 'string'],
        ]);

        $validated = array_merge($validated, $this->calculateBaseBudget($validated));

        $budget->update($validated);

        $budget->final_total = $budget->calculated_final_total;
        $budget->save();

        return redirect()->route('budgets.index')->with('success', 'Presupuesto base actualizado correctamente.');
    }

    public function destroy(Budget $budget)
    {
        abort_unless(auth()->user()->role === 'administrador', 403);

        $budget->delete();

        return redirect()->route('budgets.index')->with('success', 'Presupuesto eliminado correctamente.');
    }

    public function pdfBase(Budget $budget)
    {
        abort_unless(auth()->user()->role === 'administrador', 403);

        $budget->load(['job.client', 'changes.createdBy']);

        $pdf = Pdf::loadView('budgets.pdf.base', [
            'budget' => $budget,
        ])->setPaper('a4');

        return $pdf->download('presupuesto-base-' . $budget->id . '.pdf');
    }

    public function pdfFinal(Budget $budget)
    {
        abort_unless(auth()->user()->role === 'administrador', 403);

        $data = $this->finalPdfData($budget, true);

        $pdf = Pdf::loadView('budgets.pdf.final', $data)->setPaper('a4');

        return $pdf->download('presupuesto-final-' . $budget->id . '.pdf');
    }

  public function sendPdf(Request $request, Budget $budget)
{
    abort_unless(auth()->user()->role === 'administrador', 403);

    $validated = $request->validate([
        'email' => ['nullable', 'email'],
    ]);

    $email = $validated['email'] ?? $budget->job?->client?->email;
    abort_unless($email, 422, 'El cliente no tiene correo.');

    $pdf = Pdf::loadView('budgets.pdf.email', $this->emailPdfData($budget))
        ->setPaper('a4');

    Mail::to($email)->send(
        new BudgetPdfMail($budget, $pdf->output())
    );

    return back()->with('success', 'Presupuesto enviado por correo correctamente.');
}
    private function calculateBaseBudget(array $data): array
    {
        $estimatedHours = (float) ($data['estimated_time_hours'] ?? 0);
        $laborHours = (float) ($data['labor_hours'] ?? 0);
        $materialCost = (float) ($data['material_cost'] ?? 0);
        $discountAmount = (float) ($data['discount_amount'] ?? 0);
        $taxRate = (float) ($data['tax_rate'] ?? 0);
        $profitMargin = (float) ($data['profit_margin'] ?? 0);

        $laborCost = $laborHours * self::LABOR_RATE;
        $baseCost = $laborCost + $materialCost;
        $profitAmount = $baseCost * ($profitMargin / 100);

        $subtotal = $baseCost + $profitAmount - $discountAmount;
        $estimatedTotal = max(0, $subtotal * (1 + $taxRate / 100));

        return [
            'estimated_total' => round($estimatedTotal, 2),
            'final_total' => round($estimatedTotal, 2),
            'time_difference_hours' => round($laborHours - $estimatedHours, 2),
        ];
    }

    private function finalPdfData(Budget $budget, bool $showInternal = false): array
    {
        $budget->load(['job.client', 'changes.createdBy']);

        $changes = $budget->changes->sortBy('created_at')->values();
        $approvedTotal = round((float) $changes->where('status', 'aprobado')->sum('amount'), 2);
        $pendingTotal = round((float) $changes->where('status', 'pendiente')->sum('amount'), 2);
        $rejectedTotal = round((float) $changes->where('status', 'rechazado')->sum('amount'), 2);
        $finalTotal = round((float) $budget->estimated_total + $approvedTotal, 2);

        return [
            'budget' => $budget,
            'changes' => $changes,
            'approvedTotal' => $approvedTotal,
            'pendingTotal' => $pendingTotal,
            'rejectedTotal' => $rejectedTotal,
            'finalTotal' => $finalTotal,
            'showInternal' => $showInternal,
        ];
    }

    private function emailPdfData(Budget $budget): array
{
    $budget->load(['job.client', 'changes.createdBy']);

    $changes = $budget->changes->sortBy('created_at')->values();
    $approvedTotal = round((float) $changes->where('status', 'aprobado')->sum('amount'), 2);
    $pendingTotal = round((float) $changes->where('status', 'pendiente')->sum('amount'), 2);
    $rejectedTotal = round((float) $changes->where('status', 'rechazado')->sum('amount'), 2);

    $baseTotal = (float) $budget->estimated_total;
    $finalTotal = round($baseTotal + $approvedTotal, 2);

    return [
        'budget' => $budget,
        'changes' => $changes,
        'approvedTotal' => $approvedTotal,
        'pendingTotal' => $pendingTotal,
        'rejectedTotal' => $rejectedTotal,
        'baseTotal' => $baseTotal,
        'finalTotal' => $finalTotal,
    ];
}
}