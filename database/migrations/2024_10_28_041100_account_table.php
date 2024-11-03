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
        Schema::create('accounts', function(Blueprint $table){ 
            $table->id();
            $table->string('name')->unique()->comment('會員暱稱');
            $table->string('account', 12)->unique()->comment('帳號');
            $table->string('password')->comment('密碼');
            $table->string('email')->unique()->comment('電子郵件');
            $table->string('phone', 12)->unique()->comment('手機號碼');
            $table->date('email_verified_at')->nullable()->comment('郵箱驗證時間');
            $table->date('phone_verified_at')->nullable()->comment('手機驗證時間');
            $table->rememberToken()->comment('記住我 Token');  
            $table->timestamps(); 
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts');
        Schema::dropIfExists('password_reset_tokens');
    }
};
