<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vendor_evaluations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects');
            $table->foreignId('vendor_id')->constrained('vendors');
            $table->decimal('quality_score', 5, 2);
            $table->decimal('timeline_score', 5, 2);
            $table->decimal('cooperation_score', 5, 2);
            $table->text('notes');
            $table->integer('evaluated_by');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendor_evaluations');
    }
};
