<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Account extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('user',function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('name',30)->unique();
            $table->string('mobile',20)->unique();
            $table->string('password',60);
            $table->string('rember_token',100);
            $table->boolean('valid')->default(1);
            $table->string('description',100);
            $table->softDeletes();
            $table->timestamps();
        });



        Schema::create('role',function(Blueprint $table){
            $table->increments('id');
            $table->string('name');
            $table->string('display_name');
            $table->string('description');
            $table->timestamps();

        });

        Schema::create('user_role',function(Blueprint $table){
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('role_id');
            $table->timestamps();
        });

        Schema::create('permission',function(Blueprint $table){
            $table->increments('id');
            $table->integer('menu_id');
            $table->string('name',20)->unique();
            $table->string('display_name',50);
            $table->string('route_name');
            $table->string('show')->default(0);
            $table->string('description');
            $table->timestamps();
        });

        Schema::create('role_permission',function(Blueprint $table){
            $table->increments('id');
            $table->integer('role_id');
            $table->integer('permission_id');
            $table->timestamps();
        });

        Schema::create('menu',function(Blueprint $table){
            $table->increments('id');
            $table->string('prefix',50)->unique();
            $table->string('name',50)->unique();
            $table->string('icon',20);
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
        Schema::dropIfExists('role_permission');
        Schema::dropIfExists('permission');
        Schema::dropIfExists('user_role');
        Schema::dropIfExists('role');
        Schema::dropIfExists('user');
        Schema::dropIfExists('menu');
    }
}
