<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $table->dropColumn(['name','otp','email','password','email_verified_at','remember_token']);
        });
    }

    public function down(): void
    {
        //
    }
};