<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLandUseTuscanyRegionalPriceTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('land_use_tuscany_regional_price', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('land_use_id');
            $table->foreign('land_use_id')->references('id')->on('land_uses');
            $table->unsignedBigInteger('tuscany_regional_price_id');
            $table->foreign('tuscany_regional_price_id')->references('id')->on('tuscany_regional_prices');
            $table->unique(['land_use_id', 'tuscany_regional_price_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('land_use_tuscany_regional_price');
    }
}
