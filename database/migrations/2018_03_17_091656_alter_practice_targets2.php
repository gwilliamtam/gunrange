<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterPracticeTargets2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('practice_targets', function (Blueprint $table) {
            $table->integer('distance')->nullable();
            $table->text('units', 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('practice_targets', function (Blueprint $table) {
            $table->dropColumn('distance');
            $table->dropColumn('units');
        });
    }
}
