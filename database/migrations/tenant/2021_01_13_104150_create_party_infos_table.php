<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartyInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('party_infos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('type_infos_id')->nullable();
            $table->string('code')->unique();
            // $table->timestamp('deleted_at')->nullable();
            $table->boolean('is_enabled')->default(false);
            $table->string('created_by')->nullable();
            $table->string('modified_by')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('type_infos_id')->references('id')->on('type_infos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('party_infos');
    }
}
