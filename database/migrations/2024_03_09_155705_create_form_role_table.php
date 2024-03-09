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
        Schema::create('form_role', function (Blueprint $table) {
            $table->unsignedBigInteger('form_id')->nullable();
            $table->unsignedBigInteger('role_id')->nullable();

            $table->primary(['form_id', 'role_id']);

            $table->foreign('form_id')->references('id')->on('forms');
            $table->foreign('role_id')->references('id')->on('roles');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_role');
    }
};
