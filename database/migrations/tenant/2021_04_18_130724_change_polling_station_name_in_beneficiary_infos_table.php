<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangePollingStationNameInBeneficiaryInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('beneficiary_infos', function (Blueprint $table) {

            $table->dropColumn('polling_station_name');

            $table->unsignedBigInteger('polling_station_id')->nullable();
            $table->foreign('polling_station_id')->references('id')->on('polling_stations')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('beneficiary_infos', function (Blueprint $table) {
            
            $table->string('polling_station_name')->nullable();            
        });
    }
}
