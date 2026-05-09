<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\BudgetChange;
use Illuminate\Http\Request;

class BudgetChangeController extends Controller
{
    public function store(Request $request, Budget $budget)
    {
        abort_unless(auth()->user()->role === 'administrador', 403);

        $validated = $request->validate([
            'kind' => ['required', 'in:imprevisto,materiales,desplazamiento,urgencia,descuento,beneficio,otro'],
            'description' => ['required', 'string'],
            'amount' => ['required', 'numeric'],
            'status' => ['required', 'in:pendiente,aprobado,rechazado'],
            'visible_to_customer' => ['nullable', 'boolean'],
        ]);

        $validated['created_by'] = auth()->id();
        $validated['visible_to_customer'] = $request->boolean('visible_to_customer');

        $budget->changes()->create($validated);

        $this->recalculateBudget($budget);

        return back()->with('success', 'Cambio añadido correctamente.');
    }

    public function destroy(BudgetChange $budgetChange)
    {
        abort_unless(auth()->user()->role === 'administrador', 403);

        $budget = $budgetChange->budget;
        $budgetChange->delete();

        $this->recalculateBudget($budget);

        return back()->with('success', 'Cambio eliminado correctamente.');
    }

    private function recalculateBudget(Budget $budget): void
    {
        $budget->refresh();

        $budget->final_total = $budget->calculated_final_total;
        $budget->save();
    }
}