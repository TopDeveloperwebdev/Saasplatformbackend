<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Orders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->longText('orderMedications')->nullable();
            $table->string('orderId')->nullable();
            $table->string('patient')->nullable();
            $table->string('pharmacy')->nullable(); 
            $table->string('doctor')->nullable();
            $table->string('date')->nullable();
            $table->string('note')->nullable();
            $table->string('user_id')->nullable();
            $table->string('instance_id')->nullable();
             $table->boolean('status')->default(false);
                $table->boolean('done')->default(false);
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
