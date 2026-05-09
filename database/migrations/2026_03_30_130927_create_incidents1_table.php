<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('incidents', function (Blueprint $table) {
            $table->id();

            $table->foreignId('job_id')->constrained('jobs')->cascadeOnDelete();
            $table->foreignId('phase_id')->nullable()->constrained('phases')->nullOnDelete();
            $table->foreignId('reported_by')->nullable()->constrained('users')->nullOnDelete();

            $table->text('cause');
            $table->date('incident_date');
            $table->text('resolution')->nullable();

            $table->unsignedInteger('delay_minutes')->nullable();
            $table->boolean('affects_budget')->default(false);
            $table->boolean('affects_deadline')->default(false);

            $table->string('status', 20)->default('abierta'); // abierta, en_proceso, resuelta

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('incidents');
    }
};