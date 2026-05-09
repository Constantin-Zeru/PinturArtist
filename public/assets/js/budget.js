document.addEventListener('DOMContentLoaded', function () {
    const laborRate = 20;

    const estimatedTimeHours = document.getElementById('estimated_time_hours');
    const laborHours = document.getElementById('labor_hours');
    const materialCost = document.getElementById('material_cost');
    const discountAmount = document.getElementById('discount_amount');
    const taxRate = document.getElementById('tax_rate');
    const profitMargin = document.querySelector('input[name="profit_margin"]');

    const estimatedTotal = document.getElementById('estimated_total');
    const timeDifferenceHours = document.getElementById('time_difference_hours');

    if (
        !estimatedTimeHours ||
        !laborHours ||
        !materialCost ||
        !discountAmount ||
        !taxRate ||
        !profitMargin ||
        !estimatedTotal ||
        !timeDifferenceHours
    ) {
        return;
    }

    function num(value) {
        const parsed = parseFloat(value);
        return Number.isNaN(parsed) ? 0 : parsed;
    }

    function formatMoney(value) {
        return value.toFixed(2);
    }

    function updateTotals() {
        const estHours = num(estimatedTimeHours.value);
        const realHours = num(laborHours.value);
        const materials = num(materialCost.value);
        const discount = num(discountAmount.value);
        const tax = num(taxRate.value);
        const margin = num(profitMargin.value);

        const labor = realHours * laborRate;
        const baseCost = labor + materials;
        const profit = baseCost * (margin / 100);

        const subtotal = baseCost + profit - discount;
        const total = Math.max(0, subtotal * (1 + tax / 100));

        estimatedTotal.value = formatMoney(total);
        timeDifferenceHours.value = formatMoney(realHours - estHours);
    }

    [
        estimatedTimeHours,
        laborHours,
        materialCost,
        discountAmount,
        taxRate,
        profitMargin
    ].forEach(function (input) {
        input.addEventListener('input', updateTotals);
    });

    updateTotals();
});