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
        Schema::table('sales', function (Blueprint $table) {
            $table->decimal('cash_exchange_amount', 10, 2)->nullable()->after('balance_amount'); // Add cash_exchange_amount
            $table->decimal('cheque_exchange_amount', 10, 2)->nullable()->after('cash_exchange_amount'); // Add cheque_exchange_amount
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropColumn(['cash_exchange_amount', 'cheque_exchange_amount']); // Drop the columns
        });
    }
};
