<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserRelationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_relations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('relation_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('beneficiary_id')->nullable();
            $table->unsignedBigInteger('family_budget')->nullable();

            $table->boolean('is_enabled')->default(true);
            $table->string('created_by')->nullable();
            $table->string('modified_by')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->unique(['relation_id', 'user_id', 'beneficiary_id'], 'unique_r_u_s');
            $table->foreign('relation_id')->references('id')->on('relations')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('beneficiary_id')->references('id')->on('beneficiary_infos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('beneficiary_relations');
    }
}
