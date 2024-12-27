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
    Schema::table('cashinstallment_payments', function (Blueprint $table) {
        $table->string('bank_name')->nullable();
        $table->string('account_holder_name')->nullable();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cashinstallment_payments', function (Blueprint $table) {
            //
        });
    }
};
