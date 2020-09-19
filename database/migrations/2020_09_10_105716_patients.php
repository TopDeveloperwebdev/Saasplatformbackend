<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Patients extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('patients', function (Blueprint $table) {
            $table->increments('id');
            $table->string('salutation')->nullable();
            $table->string('firstName')->nullable();
            $table->string('lastName')->nullable();
            $table->string('streetNr')->nullable();
            $table->string('zipCode')->nullable();
            $table->string('city')->nullable();
            $table->string('birthday')->nullable();
            $table->string('phone1')->nullable();
            $table->string('phone2')->nullable();
            $table->string('email')->nullable();
            $table->string('picture')->nullable();
            $table->string('resources')->nullable();
            $table->string('insurance')->nullable();
            $table->string('services')->nullable();
            $table->string('familyDoctor')->nullable();
            $table->integer('keyNumber')->nullable();
            $table->integer('floor')->nullable();
            $table->string('degreeCare')->nullable();
            $table->string('pharmacy')->nullable();
            $table->string('userGroup')->nullable();
            $table->string('status')->default(0);
            $table->integer('instance_id')->default(0);
             $table->boolean('serviceplan')->default(0);
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
