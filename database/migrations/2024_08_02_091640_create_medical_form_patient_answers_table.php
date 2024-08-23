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
        Schema::create('medical_form_patient_answers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('medical_form_id');
            $table->unsignedBigInteger('user_id');
            $table->text('code')->nullable();
            $table->json('answers')->nullable();
            $table->foreign('medical_form_id')->references('id')->on('medical_forms')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamp('last_answers_at')->nullable()->default(\Carbon\Carbon::now());
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_form_patient_answers');
    }
};
