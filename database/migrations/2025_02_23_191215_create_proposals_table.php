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
        Schema::create('proposals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tender_id')->constrained('tenders');
            $table->foreignId('vendor_id')->constrained('vendors');
            $table->decimal('price_amount', 15, 2);
            $table->text('technical_description');
            $table->timestamp('submission_date');
            $table->decimal('technical_score', 5, 2);
            $table->decimal('price_score', 5, 2);
            $table->string('status', 50);
            $table->timestamps();

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proposals');
    }
};
