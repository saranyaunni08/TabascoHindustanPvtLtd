<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('extra_expense_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cash_installment_id')->constrained()->onDelete('cascade');
            $table->string('description'); // Description of the extra expense
            $table->decimal('percentage', 5, 2); // Percentage for the extra expense
            $table->decimal('amount', 10, 2); // Amount corresponding to the extra expense
            $table->timestamps();
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('extra_expense_payments');
    }
};
