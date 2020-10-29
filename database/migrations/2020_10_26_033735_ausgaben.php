<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Ausgaben extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('ausgaben', function (Blueprint $table) {
            $table->increments('id');  
            $table->string('date')->nullable();     
            $table->string('invoiceNr')->nullable();          
            $table->string('reason')->nullable();
            $table->string('type')->nullable();        
             $table->string('user')->nullable();
            $table->string('car')->nullable(); 
            $table->string('amount')->nullable();   
            $table->string('link')->nullable();
            $table->string('booked')->nullable();  
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
