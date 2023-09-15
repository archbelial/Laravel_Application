<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paid_leaves', function (Blueprint $table) {
            $table->id();
            $table->string('EMPLOYEE_CODE', 50);
            $table->foreign('EMPLOYEE_CODE')
                  ->references('CODE')
                  ->on('employees');
            $table->string('NAME', 250);
            $table->string('GENDER', 20);
            $table->string('POSITION', 50);
            $table->string('LEVEL', 20);
            $table->string('ISONEDAY', 1);
            $table->string('REMARK', 4000)->nullable();
            $table->string('STATUS', 20)->nullable();
            $table->integer('COUNTER');
            $table->dateTime('PAID_LEAVE_START')->nullable();
            $table->dateTime('PAID_LEAVE_END')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paid_leaves');
    }
};
