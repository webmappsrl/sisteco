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
            $table->string('code_belfiore');
            $table->string('code_foglio');
            $table->string('code_parcel');
            $table->string('code');
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
