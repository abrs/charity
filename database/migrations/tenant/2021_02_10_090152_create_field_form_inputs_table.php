<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFieldFormInputsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('field_form_inputs', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('form_field_id');
            $table->foreign('form_field_id')->references('id')->on('form_fields')->onUpdate('cascade')->onDelete('cascade');

            $table->unsignedBigInteger('form_property_id');
            $table->foreign('form_property_id')->references('id')->on('form_properties')->onUpdate('cascade')->onDelete('cascade');

            $table->unsignedBigInteger('field_property_id');
            $table->foreign('field_property_id')->references('id')->on('field_properties')->onUpdate('cascade')->onDelete('cascade');

            $table->unsignedBigInteger('input_id');
            $table->foreign('input_id')->references('id')->on('inputs')->onUpdate('cascade')->onDelete('cascade');

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
        Schema::dropIfExists('field_form_inputs');
    }
}
