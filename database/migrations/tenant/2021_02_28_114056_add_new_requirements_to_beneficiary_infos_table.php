<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewRequirementsToBeneficiaryInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('beneficiary_infos', function (Blueprint $table) {
    
            $table->string('first_name')->nullable();
            $table->string('second_name')->nullable();
            $table->string('third_name')->nullable();
            $table->string('fourth_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('known_as')->nullable();
            $table->string('career')->nullable();
            $table->string('polling_station_name')->nullable();
            $table->string('standing')->nullable();
            
            $table->date('date_of_death')->nullable();
            $table->boolean('is_special_needs')->default(0);
            $table->date('birth')->nullable();
            $table->boolean('gender')->default(0);
            $table->unsignedBigInteger('national_number')->nullable();
            $table->unsignedInteger('age')->nullable();
            $table->string('email')->nullable();

            $table->boolean('is_alive')->default(1);

            // $table->unsignedBigInteger('special_needs_type_id')->nullable();

            // $table->foreign('special_needs_type_id')->references('id')->on('special_need_types')->onDelete('cascade');
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
            $table->dropColumn([
                'first_name',
                'second_name',
                'third_name',
                'fourth_name',
                'last_name',
                'known_as',
                'career',
                'polling_station_name',
                'standing',
                'date_of_death',
                'is_special_needs',
                'birth',
                'gender',
                'national_number',
                'age',
                'email',
                'is_alive',
                'type_infos_id',
                // 'special_needs_type_id',
            ]);
        });
    }
}
