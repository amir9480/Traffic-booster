<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserManagmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('user_managment')==false)
        {
        Schema::create('user_managment', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',255)->nullable();
            $table->string('username',255)->unique();
            $table->string('email',1024)->unique();
            $table->string('password',1024);
            $table->unsignedInteger('point')->default('1000');
            $table->string('usersession',1024)->default('0');
            $table->timestamps();
           
        });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_managment');
    }
}
