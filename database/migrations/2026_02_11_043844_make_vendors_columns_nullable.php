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
        //
            Schema::table('vendors', function (Blueprint $table) {
            $table->string('id_number')->nullable()->change();
            $table->string('business_name')->nullable()->change();
            $table->string('business_type')->nullable()->change();
            $table->string('gst_number')->nullable()->change();
            $table->string('business_category')->nullable()->change();
            $table->string('bank_account_number')->nullable()->change();
            $table->string('payment_method')->nullable()->change();
            $table->string('image')->nullable()->change();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
