<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormPropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_properties', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('form_id');
            $table->foreign('form_id')->references('id')->on('forms')->onUpdate('cascade')->onDelete('cascade');

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
        Schema::dropIfExists('form_properties');
    }
}
