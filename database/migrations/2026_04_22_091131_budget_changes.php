<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('budget_changes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('budget_id')->constrained('budgets')->cascadeOnDelete();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();

            $table->string('kind', 50); // imprevisto, materiales, desplazamiento, urgencia, descuento, beneficio, otro
            $table->text('description');
            $table->decimal('amount', 10, 2)->default(0); // positivo suma, negativo resta
            $table->string('status', 20)->default('pendiente'); // pendiente, aprobado, rechazado
            $table->boolean('visible_to_customer')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('budget_changes');
    }
};