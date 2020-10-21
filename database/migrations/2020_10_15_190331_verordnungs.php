<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Verordnungs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('verordnungs', function (Blueprint $table) {
            $table->increments('id');
            $table->longText('content')->nullable();                        
            $table->string('patient')->nullable();
            $table->string('from')->nullable();
            $table->string('to')->nullable();
            $table->string('type')->nullable();
            $table->string('instance_id')->nullable();
            $table->string('send_date')->nullable();
            $table->boolean('status')->default(false);
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
