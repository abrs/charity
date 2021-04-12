<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivityWorkflowStepsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity_workflow_steps', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->boolean('is_enabled')->default(true);
            $table->string('created_by')->nullable();
            $table->string('modified_by')->nullable();
            $table->softDeletes();
            
            $table->unsignedBigInteger('activitable_id')->nullable();
            $table->unsignedBigInteger('step_id')->nullable();
            $table->unsignedInteger('order_num');
            $table->string('finishing_percentage')->nullable();
            $table->boolean('required')->default(true);
            $table->timestamps();

            $table->foreign('activitable_id')->references('id')->on('activitable')->onDelete('cascade');
            $table->foreign('step_id')->references('id')->on('steps')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activity_workflow_steps');
    }
}
