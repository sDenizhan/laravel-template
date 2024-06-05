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
        Schema::create('medical_form_question_answers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('medical_form_question_id')->unsigned();
            $table->bigInteger('medical_form_id')->unsigned();
            $table->text('answer');
            $table->integer('order')->default(1);

            $table->foreign('medical_form_question_id')->references('id')->on('medical_form_questions')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('medical_form_id')->references('id')->on('medical_forms')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_form_question_answers');
    }
};
