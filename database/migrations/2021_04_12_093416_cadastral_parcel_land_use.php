<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CadastralParcelLandUse extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('cadastral_parcel_land_use', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('cadastral_parcels_id');
            $table->foreign('cadastral_parcels_id')->references('id')->on('cadastral_parcels');
            $table->unsignedBigInteger('land_use_id');
            $table->foreign('land_use_id')->references('id')->on('land_uses');
            $table->float("square_meter_surface");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('cadastral_parcel_land_use');
    }
}
