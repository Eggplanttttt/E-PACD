<?php

// database/migrations/xxxx_xx_xx_create_client_bans_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('client_bans', function (Blueprint $table) {
      $table->id();
      $table->string('client_type');   // Student, Alumni, Others, etc
      $table->unsignedBigInteger('client_id')->nullable(); // if you have it
      $table->string('email')->nullable(); // fallback when no client_id
      $table->unsignedInteger('strikes')->default(0);
      $table->timestamp('banned_until')->nullable();
      $table->boolean('is_permanent')->default(false);
      $table->string('last_reason')->nullable();
      $table->text('last_message')->nullable();
      $table->timestamps();

      $table->index(['client_type', 'client_id']);
      $table->index(['client_type', 'email']);
    });
  }

  public function down(): void {
    Schema::dropIfExists('client_bans');
  }
};
