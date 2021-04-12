<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStepSupervisorReferencesToActivityWorkflowStepsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('activity_workflow_steps', function (Blueprint $table) {
            $table->string('step_supervisor_type')->nullable()->after('step_id');
            $table->unsignedBigInteger('step_supervisor_id')->nullable()->after('step_id');
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
            $table->dropColumn(['step_supervisor_type', 'step_supervisor_id']);
        });
    }
}
