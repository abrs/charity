<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInputsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inputs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('label');
            $table->enum('type',['string','date','dateTime','boolean','int','float','image','pdf','office','textFile','select','mobile']);
            $table->string('value');
            $table->unsignedBigInteger('input_id')->nullable();
            $table->foreign('input_id')->references('id')->on('inputs')->onUpdate('cascade')->onDelete('cascade');

            $table->unsignedBigInteger('property_id');
            $table->foreign('property_id')->references('id')->on('properties')->onUpdate('cascade')->onDelete('cascade');

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
        Schema::dropIfExists('inputs');
    }
}
