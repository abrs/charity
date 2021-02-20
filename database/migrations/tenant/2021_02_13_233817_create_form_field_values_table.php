<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormFieldValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_field_values', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('form_id');
            $table->foreign('form_id')->references('id')->on('forms')->onUpdate('cascade')->onDelete('cascade');

            $table->unsignedBigInteger('field_id');
            $table->foreign('field_id')->references('id')->on('fields')->onUpdate('cascade')->onDelete('cascade');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('owner_id');
            $table->foreign('owner_id')->references('id')->on('users')->onDelete('cascade');
            
            $table->string('value');

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
        Schema::dropIfExists('form_field_values');
    }
}
