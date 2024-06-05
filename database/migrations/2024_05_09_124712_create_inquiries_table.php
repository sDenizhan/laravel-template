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
        Schema::create('enquiries', function (Blueprint $table) {
            $table->id();
            $table->integer('treatment_id');
            $table->integer('status')->default(0); //onaylandı, reddedildi, bekliyor,
            $table->integer('gender')->default(\App\Enums\Gender::None->value);

            $table->text('name');
            $table->text('surname');
            $table->text('email');
            $table->text('phone');
            $table->text('message')->nullable();
            $table->text('country')->nullable();
            $table->text('ip_address')->nullable();

            $table->integer('assignment_by')->default(0);
            $table->integer('assignment_to')->default(0); // 0 => Atanmayanlar 0> = Atananlar
            $table->timestamp('assignment_at')->nullable();

            $table->text('extra_data1')->nullable();
            $table->text('extra_data2')->nullable();
            $table->text('extra_data3')->nullable();

            $table->foreign('treatment_id')->references('id')->on('treatments')
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
        Schema::dropIfExists('enquiries');
    }
};
