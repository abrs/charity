<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBeneficiaryTypeIdToBeneficiaryInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('beneficiary_infos', function (Blueprint $table) {

            $table->unsignedBigInteger('beneficiary_type_id')->nullable();
            $table->foreign('beneficiary_type_id')->references('id')->on('beneficiary_types')->onDelete('cascade');
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
            $table->dropForeign('beneficiary_type_id');
            $table->dropColumn('beneficiary_type_id');
        });
    }
}
