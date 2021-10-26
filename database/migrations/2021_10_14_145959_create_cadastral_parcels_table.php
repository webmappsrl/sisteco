<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCadastralParcelsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('cadastral_parcels', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('code')->unique();
            $table->geometry('geometry');
            $table->float('estimated_value')->default(0);
            $table->float('average_slope')->default(0);
            $table->float('meter_min_distance_path')->default(0);
            $table->float('meter_min_distance_road')->default(0);
            $table->float('square_meter_surface')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('cadastral_parcels');
    }
}
