<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Medications extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('medications', function (Blueprint $table) {
            $table->increments('id');
            $table->string('medicationName');
            $table->string('ingredients')->nullable();
            $table->string('packaging')->nullable();
            $table->integer('orders')->nullable();
            $table->integer('patients')->nullable();
            $table->integer('instance_id')->default(0);
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
        //
    }
}
