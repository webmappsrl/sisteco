<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSlopeAndWayToCadastralParcels extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cadastral_parcels', function (Blueprint $table) {
            $table->integer('slope')->nullable();
            $table->integer('way')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cadastral_parcels', function (Blueprint $table) {
            $table->dropColumn('slope');
            $table->dropColumn('way');
        });
    }
}
