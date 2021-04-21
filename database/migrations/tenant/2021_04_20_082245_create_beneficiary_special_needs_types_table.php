<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBeneficiarySpecialNeedsTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('beneficiary_special_needs_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('beneficiary_id');
            $table->unsignedBigInteger('special_needs_type_id');
            
            $table->boolean('is_enabled')->default(true);
            $table->string('created_by')->nullable();
            $table->string('modified_by')->nullable();
            $table->softDeletes();

            $table->timestamps();

            $table->unique(['beneficiary_id', 'special_needs_type_id'], 'unique_ben_spc_need');

            $table->foreign('beneficiary_id')->references('id')->on('beneficiary_infos')->onDelete('cascade');
            $table->foreign('special_needs_type_id')->references('id')->on('special_need_types')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('beneficiary_special_needs_types');
    }
}
