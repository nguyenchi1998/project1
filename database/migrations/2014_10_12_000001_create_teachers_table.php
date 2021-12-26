<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teachers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('code')->nullable();
            $table->string('email')->unique();
            $table->boolean('gender');
            $table->date('birthday');
            $table->string('address')->nullable();
            $table->string('experience')->nullable();
            $table->string('phone')->nullable();
            $table->string('password');
            $table->unsignedInteger('department_id')->nullable();
            $table->unsignedInteger('next_department_id')->nullable();
            $table->boolean('next_department_status')
                ->default(config('status.teacher.next_department.pending'));
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
        Schema::dropIfExists('users');
    }
}
