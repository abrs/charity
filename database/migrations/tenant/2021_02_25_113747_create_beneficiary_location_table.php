<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBeneficiaryLocationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('beneficiary_location', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('location_type_id');
            $table->unsignedBigInteger('beneficiary_id');
            $table->unsignedBigInteger('location_id');

            $table->boolean('is_enabled')->default(true);
            $table->string('created_by')->nullable();
            $table->string('modified_by')->nullable();
            $table->softDeletes();

            $table->timestamps();

            $table->unique(["location_type_id", "beneficiary_id", "location_id"], 'unique_lbl');
            $table->foreign('location_type_id')->references('id')->on('location_types')->onDelete('cascade');
            $table->foreign('beneficiary_id')->references('id')->on('beneficiary_infos')->onDelete('cascade');
            $table->foreign('location_id')->references('id')->on('locations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('beneficiary_location');
    }
}
