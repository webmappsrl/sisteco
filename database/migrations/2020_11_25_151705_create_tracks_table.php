<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
Use Illuminate\Support\Facades\DB;

class CreateTracksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tracks', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->text('description');
            $table->timestamps();
            $table->text('geometry');
            $table->unsignedBigInteger('layer_id');
            $table->hstore('properties');

            $table->foreign('layer_id')
            ->references('id')
            ->on('track_layers')
            ->onDelete('cascade');
        });

        DB::statement('ALTER TABLE tracks ALTER COLUMN geometry TYPE geometry(LineString, 3857) USING geometry::geometry(LineString,3857);');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tracks');
    }
}
