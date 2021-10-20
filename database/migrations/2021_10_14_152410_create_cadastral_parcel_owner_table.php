<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCadastralParcelOwnerTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('cadastral_parcel_owner', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('cadastral_parcel_id');
            $table->foreign('cadastral_parcel_id')->references('id')->on('cadastral_parcels');
            $table->unsignedBigInteger('owner_id');
            $table->foreign('owner_id')->references('id')->on('owners');
            $table->unique(['cadastral_parcel_id', 'owner_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('cadastral_parcel_owner');
    }
}
