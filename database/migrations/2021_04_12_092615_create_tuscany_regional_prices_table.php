<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTuscanyRegionalPricesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('tuscany_regional_prices', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('regional_code');
            $table->text('description');
            $table->float('square_meter_price');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('tuscany_regional_prices');
    }
}
