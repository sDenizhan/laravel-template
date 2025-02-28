<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('code', 2)->unique();  // ISO 3166-1 alpha-2 (TR, US, GB)
            $table->string('code_alpha3', 3)->unique(); // ISO 3166-1 alpha-3 (TUR, USA, GBR)
            $table->string('phone_code', 11); // +90, +1, +44
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('country_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('country_id')->constrained()->onDelete('cascade');
            $table->string('locale', 2); // tr, en, de, fr
            $table->string('name'); // Türkiye, Turkey, Türkei, Turquie
            $table->unique(['country_id', 'locale']);
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('country_translations');
        Schema::dropIfExists('countries');
    }
};
