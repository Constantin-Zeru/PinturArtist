<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('budgets', function (Blueprint $table) {
            $table->id();

            $table->foreignId('job_id')->constrained('jobs')->cascadeOnDelete()->unique();

            $table->decimal('estimated_time_hours', 8, 2)->nullable();
            $table->decimal('labor_hours', 8, 2)->nullable();

            $table->decimal('material_cost', 10, 2)->default(0);
            $table->decimal('travel_cost', 10, 2)->default(0);
            $table->decimal('contingency_cost', 10, 2)->default(0);
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->decimal('tax_rate', 5, 2)->default(21.00);
            $table->decimal('urgent_surcharge', 10, 2)->default(0);

            $table->decimal('estimated_total', 10, 2)->nullable();
            $table->decimal('final_total', 10, 2)->nullable();
            $table->decimal('profit_margin', 5, 2)->nullable();
            $table->decimal('time_difference_hours', 8, 2)->nullable();

            $table->string('status', 20)->default('borrador'); // borrador, enviado, aceptado, rechazado
            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('budgets');
    }
};