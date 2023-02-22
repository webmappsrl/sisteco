<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCatalogEstimateToCadastralParticles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cadastral_parcels', function (Blueprint $table) {
            $table->json('catalog_estimate')->nullable();
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
            $table->dropColumn('catalog_estimate');
        });
    }
}
