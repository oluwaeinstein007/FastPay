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
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('phone_number')->nullable();
            // $table->foreignId('user_role_id')->constrained('user_roles');
            $table->tinyInteger('user_role_id')->default(3);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('social_type')->nullable();
            $table->boolean('is_social')->default(0);
            $table->boolean('is_suspended')->default(0);
            $table->rememberToken();
            $table->timestamps();
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
