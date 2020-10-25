<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Caremanagers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('caremanagers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ansprechpartner');
            $table->string('klinik')->nullable();          
            $table->string('fax')->nullable();
            $table->string('email')->nullable();        
             $table->string('salutation')->nullable();
            $table->string('firstName')->nullable(); 
            $table->string('lastName')->nullable();   
            $table->boolean('notifications')->default(0);      
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
