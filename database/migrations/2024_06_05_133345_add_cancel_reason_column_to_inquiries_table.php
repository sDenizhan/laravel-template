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
        Schema::table('inquiries', function (Blueprint $table) {
            $table->bigInteger('language_id')->nullable()->after('treatment_id');
            $table->bigInteger('user_id')->default(0)->after('language_id');
            $table->text('cancel_reason')->nullable()->after('extra_data1');

            $table->foreign('language_id')->references('id')->on('languages')
                ->onDelete('set null')->onUpdate('cascade');

            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('set default')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inquiries', function (Blueprint $table) {
            $table->dropColumn(['language_id', 'cancel_reason']);
        });
    }
};
