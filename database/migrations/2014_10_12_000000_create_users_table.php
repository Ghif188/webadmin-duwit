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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('account_code')->unique();
            $table->string('fullname');
            $table->string('phone', 13)->unique();
            $table->string('pin', 6)->nullable();
            $table->string('avatar')->nullable();
            $table->string('role')->comment('customer, patner_manager,patner_staf,admin_manager, admin_staf');
            $table->string('type')->default('regular');
            $table->string('email')->nullable();
            $table->string('status')->comment('active, block');
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['account_code', 'fullname', 'phone','created_at']);
            // $table->string('password');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
