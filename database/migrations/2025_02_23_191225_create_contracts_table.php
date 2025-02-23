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
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tender_id')->constrained('tenders');
            $table->foreignId('vendor_id')->constrained('vendors');
            $table->foreignId('proposal_id')->constrained('proposals');
            $table->string('contract_number', 50);
            $table->decimal('contract_amount', 15, 2);
            $table->date('start_date');
            $table->date('end_date');
            $table->text('terms_and_conditions');
            $table->string('status', 50);
            $table->date('signed_at');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};
