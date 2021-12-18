<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('teacher_id')->nullable();
            $table->unsignedInteger('subject_id');
            $table->unsignedInteger('semester');
            $table->unsignedInteger('credit')->nullable();
            $table->string('name')->nullable();
            $table->date('start_time')->nullable();
            $table->date('end_time')->nullable();
            $table->unsignedInteger('class_id')->nullable();
            $table->unsignedInteger('specialization_subject_id')->nullable();
            $table->unsignedInteger('status')->default(config('schedule.status.new'));
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schedules');
    }
}
