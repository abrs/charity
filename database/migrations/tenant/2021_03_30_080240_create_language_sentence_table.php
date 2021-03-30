<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLanguageSentenceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('language_sentence', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->unsignedBigInteger('sentence_id')->nullable();
            $table->unsignedBigInteger('language_id')->nullable();

            $table->boolean('is_enabled')->default(true);
            $table->string('created_by')->nullable();
            $table->string('modified_by')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->unique(['sentence_id', 'language_id']);
            $table->foreign('sentence_id')->references('id')->on('sentences')->onDelete('cascade');
            $table->foreign('language_id')->references('id')->on('languages')->onDelete('cascade');
        });
    }

    
    public function down()
    {
        Schema::dropIfExists('language_sentence');
    }
}
