<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->string('name')->nullable();
            $table->date('start_time')->nullable();
            $table->date('end_time')->nullable();
            $table->unsignedInteger('class_id')->nullable();
            $table->unsignedInteger('status')->default(config('common.status.schedule.new'));
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
        Schema::dropIfExists('schedules');
    }
}
