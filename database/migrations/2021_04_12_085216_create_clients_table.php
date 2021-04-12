<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->string('email', 100);
            $table->string('business_name', 100);
            $table->string('vat_number', 100);
            $table->string('fiscal_code', 100);
            $table->string('phone', 14);
            $table->string('addr:street', 100);
            $table->string('addr:housenumber', 6);
            $table->string('addr:city', 100);
            $table->string('addr:postcode', 10);
            $table->string('addr:province', 100);
            $table->string('addr:locality', 100);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('clients');
    }
}
