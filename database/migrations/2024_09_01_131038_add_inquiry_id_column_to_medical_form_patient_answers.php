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
        Schema::table('medical_form_patient_answers', function (Blueprint $table) {
            $table->addColumn('integer', 'inquiry_id', ['length' => 11, 'unsigned' => true, 'nullable' => false])->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('medical_form_patient_answers', function (Blueprint $table) {
            $table->dropColumn('inquiry_id');
        });
    }
};
