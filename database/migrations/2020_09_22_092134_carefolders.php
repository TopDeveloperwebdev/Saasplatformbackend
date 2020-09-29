<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Carefolders extends Migration
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
         Schema::create('carefolders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->nullable();
            $table->longText('documents')->nullable();
            $table->string('service')->nullable();
            $table->string('instance_id')->nullable();         
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
