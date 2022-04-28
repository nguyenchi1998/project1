<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('uuid');
            $table->string('email')->unique();
            $table->boolean('gender');
            $table->date('birthday');
            $table->string('avatar');
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('password');
            $table->unsignedInteger('class_room_id')->nullable();
            $table->unsignedInteger('grade_id')->nullable();
            $table->boolean('can_register_credit')->default(false);
            $table->timestamps();
            $table->rememberToken();
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
        Schema::dropIfExists('students');
    }
}
