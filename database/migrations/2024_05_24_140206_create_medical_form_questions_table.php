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
        Schema::create('medical_form_questions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('medical_form_id')->unsigned();
            $table->text('question');
            $table->text('description')->nullable();
            $table->string('type');
            $table->json('rules')->nullable();
            $table->integer('order')->default(1);

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
        Schema::dropIfExists('medical_form_questions');
    }
};
