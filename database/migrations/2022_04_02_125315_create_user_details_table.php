<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_details', function (Blueprint $table) {
            $table->id();
            $table->string('nik', 16)->unique();
            $table->string('npwp', 16)->unique();
            $table->string('gender');
            $table->string('place_of_birth');
            $table->string('date_of_birth');
            $table->boolean('is_married');
            $table->string('religion');
            $table->string('address');

            $table->string('nip');
            $table->string('company_email');
            $table->string('id_division');
            $table->string('id_position');
            $table->string('id_level');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_details');
    }
}
