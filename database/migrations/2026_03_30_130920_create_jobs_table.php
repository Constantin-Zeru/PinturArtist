<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('client_id')->constrained()->cascadeOnDelete();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();

            $table->string('name');
            $table->string('work_type', 50); // interior, exterior, fachada, local, vivienda...
            $table->string('technical_state', 20)->default('nuevo'); // nuevo, regular, malo
            $table->text('description')->nullable();

            $table->decimal('surface_m2', 10, 2)->nullable();
            $table->unsignedInteger('rooms_count')->nullable();
            $table->decimal('height_m', 5, 2)->nullable();

            $table->string('status', 20)->default('pendiente'); // pendiente, aceptado, en proceso, pausado, finalizado, cancelado
            $table->string('priority', 20)->default('media');

            $table->date('requested_at')->nullable();
            $table->date('planned_start_at')->nullable();
            $table->date('planned_end_at')->nullable();

            $table->text('technical_observations')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};