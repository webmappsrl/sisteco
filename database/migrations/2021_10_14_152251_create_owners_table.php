<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOwnersTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('owners', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->string('email', 100);
            $table->string('business_name', 100)->nullable();
            $table->string('vat_number', 100);
            $table->string('fiscal_code', 100);
            $table->string('phone', 14);
            $table->string('addr:street', 100)->nullable();
            $table->string('addr:housenumber', 6)->nullable();
            $table->string('addr:city', 100)->nullable();
            $table->string('addr:postcode', 10)->nullable();
            $table->string('addr:province', 100)->nullable();
            $table->string('addr:locality', 100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('owners');
    }
}
