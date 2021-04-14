<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusIdAndDescriptionToActivityWorkflowStepsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('activity_workflow_steps', function (Blueprint $table) {
            
            $table->unsignedBigInteger('status_id')->nullable();
            $table->text('description')->nullable()->after('status_id');

            $table->foreign('status_id')->references('id')->on('statuses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('activity_workflow_steps', function (Blueprint $table) {
            $table->dropForeign('status_id');
            $table->dropColumn(['status_id', 'description']);
        });
    }
}
