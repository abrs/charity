<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('action_name');

            // $table->foreign('action_name')
            //     ->references('name')->on('actions')
            //     ->onDelete('restrict');
                
            $table->morphs('eventable');
            $table->nullableMorphs('to_eventable');
            $table->ipAddress('ip')->nullable();
            $table->string('message')->nullable();

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
              ->references('id')->on('users')
              ->onDelete('restrict');

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
        Schema::dropIfExists('events');
    }
}
