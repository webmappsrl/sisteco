<?php

use Illuminate\Database\Migrations\Migration;
use MStaack\LaravelPostgis\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;


class CreatePoisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pois', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->text('description');
            $table->timestamps();
            $table->text('geometry')->nullable();
            $table->unsignedBigInteger('layer_id');
            $table->hstore('properties')->nullable();;

            $table->foreign('layer_id')
            ->references('id')
            ->on('poi_layers')
            ->onDelete('cascade');
        });

        DB::statement('ALTER TABLE pois ALTER COLUMN geometry TYPE geometry(Point, 4326) USING geometry::geometry(Point,4326);');
        // DB::statement('ALTER TABLE pois ALTER COLUMN properties TYPE hstore;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pois');
    }
}
