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
        Schema::create('medical_forms_notes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('medical_form_id');
            $table->unsignedBigInteger('inquiry_id');
            $table->unsignedBigInteger('user_id');
            $table->text('note');

            $table->foreign('inquiry_id')->references('id')->on('inquiries')->onDelete('cascade');
            $table->foreign('medical_form_id')->references('id')->on('medical_forms')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_forms_notes');
    }
};
