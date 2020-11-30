<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
Use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateAreasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('areas', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->text('description');
            $table->timestamps();
            $table->text('geometry')->nullable();
            $table->unsignedBigInteger('layer_id');
            $table->hstore('properties')->nullable();

            $table->foreign('layer_id')
            ->references('id')
            ->on('area_layers')
            ->onDelete('cascade');
        });

        DB::statement('ALTER TABLE areas ALTER COLUMN geometry TYPE geometry(Polygon, 28992) USING geometry::geometry(Polygon,28992);');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('areas');
    }
}
