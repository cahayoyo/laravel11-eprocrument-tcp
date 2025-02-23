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
        Schema::create('material_vendors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('material_category_id')->constrained('material_categories');
            $table->foreignId('vendor_id')->constrained('vendors');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('material_vendors');
    }
};
