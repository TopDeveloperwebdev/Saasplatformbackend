<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Instances extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        //
        Schema::create('instances', function (Blueprint $table) {
            $table->increments('id');
            $table->string('instanceLogo')->nullable();
            $table->string('instanceName')->nullable();     
            $table->string('phone')->nullable();
            $table->string('fax')->nullable();   
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
