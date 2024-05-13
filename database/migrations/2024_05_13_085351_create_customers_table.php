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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('enquiry_id')->unsigned();
            $table->bigInteger('treatment_id')->unsigned();
            $table->integer('status')->default(0);

            $table->text('name');
            $table->text('surname');
            $table->text('email');
            $table->text('phone');
            $table->text('message')->nullable();
            $table->text('country')->nullable();
            $table->text('ip_address')->nullable();
            $table->integer('gender')->default(\App\Enums\Gender::None->value);

            $table->integer('assignment_by')->default(0);
            $table->integer('assignment_to')->default(0); // 0 => Atanmayanlar 0> = Atananlar
            $table->timestamp('assignment_at')->nullable();

            $table->foreign('enquiry_id')->references('id')->on('enquiries')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
