<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPricesToCatalogTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('catalog_types', function (Blueprint $table) {
            $table->dropColumn('code');
            $table->dropColumn('price');
            $table->string('code_int')->nullable();
            $table->json('prices');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('catalog_types', function (Blueprint $table) {
            $table->string('code');
            $table->float('price');
            $table->dropColumn('code_int');
            $table->dropColumn('prices');
        });
    }
}
