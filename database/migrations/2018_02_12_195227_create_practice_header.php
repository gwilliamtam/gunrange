<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePracticeHeader extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('practice_header', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->dateTime('date_time');
            $table->integer('location_id')->nullable();
            $table->integer('gear_id')->nullable();
            $table->integer('ammo_id')->nullable();
            $table->decimal('amount')->nullable();
            $table->decimal('amount_lane')->nullable();
            $table->decimal('amount_ammo')->nullable();
            $table->decimal('amount_rent')->nullable();
            $table->decimal('amount_other')->nullable();
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
        Schema::dropIfExists('practice_header');
    }
}
