<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateManagersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('managers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('avatar')->nullable();
            $table->string('email')->unique();
            $table->boolean('gender');
            $table->date('birthday');
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('password');
            $table->unsignedTinyInteger('type')
                ->default(config('role.manager.normal'));
            $table->unsignedInteger('position')->nullable();
            $table->timestamps();
            $table->rememberToken();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('managers');
    }
}
