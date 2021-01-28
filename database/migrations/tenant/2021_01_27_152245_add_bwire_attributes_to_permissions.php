<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBwireAttributesToPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('permissions', function (Blueprint $table) {
            $table->boolean('is_enabled')->default(true);
            $table->string('created_by')->nullable();
            $table->string('modified_by')->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('permissions', function (Blueprint $table) {
            $table->dropColumn('is_enabled');
            $table->dropColumn('created_by');
            $table->dropColumn('modified_by');
            $table->dropColumn('deleted_at');
        });
    }
}
