<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScheduleDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedule_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('schedule_id')->nullable();
            $table->unsignedInteger('student_id');
            $table->unsignedInteger('subject_id');
            $table->unsignedInteger('specialization_id');
            $table->unsignedInteger('semester');
            $table->unsignedInteger('activity_mark')->nullable();
            $table->unsignedInteger('middle_mark')->nullable();
            $table->unsignedInteger('final_mark')->nullable();
            $table->unsignedInteger('result_status')->nullable();
            $table->unsignedInteger('register_status')->default(config('schedule.detail.status.register.pending'));
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
        Schema::dropIfExists('schedule_details');
    }
}
