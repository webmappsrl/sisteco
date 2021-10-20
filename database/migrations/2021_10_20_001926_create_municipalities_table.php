<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMunicipalitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('municipalities', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('code');
            $table->string('name');
        });

        Schema::table('cadastral_parcels', function (Blueprint $table) {
            $table->unsignedBigInteger('municipality_id')->nullable();
            $table->foreign('municipality_id')->references('id')->on('municipalities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $parcels = \App\Models\CadastralParcel::all();
        if (count($parcels) > 0) {
            foreach ($parcels as $parcel) {
                $parcel->municipality_id = null;
                $parcel->save();
            }
        }
        Schema::table('cadastral_parcels', function (Blueprint $table) {
            $table->dropForeign(['municipality_id']);
            $table->dropColumn('municipality_id');
        });
        Schema::dropIfExists('municipalities');
    }
}
