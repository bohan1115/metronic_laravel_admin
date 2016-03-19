<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Example extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('example',function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('name',30)->unique();
            $table->string('sn',20)->unique();
            $table->decimal('price',5,2);
            $table->boolean('status')->default(0);
            $table->string('description',100);
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
        Schema::dropIfExists('example');
    }
}
