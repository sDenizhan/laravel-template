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
        Schema::create('message_templates', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('treatment_id')->unsigned();
            $table->bigInteger('language_id')->unsigned();
            $table->text('type');
            $table->string('title');
            $table->json('message');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('language_id')->references('id')->on('languages')
                ->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('message_templates');
    }
};
