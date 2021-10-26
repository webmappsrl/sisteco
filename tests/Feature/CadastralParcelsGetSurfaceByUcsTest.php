<?php

namespace Tests\Feature;

use App\Models\CadastralParcel;
use App\Models\LandUse;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class CadastralParcelsGetSurfaceByUcsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function when_parcel_has_no_landuse_then_surface_is_zero()
    {
        $p = CadastralParcel::factory()->create();
        $this->assertEquals(0, $p->getSurfaceByUcs(100));
    }

    /**
     * @test
     */
    public function when_parcel_has_no_landuse_with_coresponding_ucs_then_surface_is_zero()
    {
        $lu = LandUse::factory()->create(['code' => 101]);
        $p = CadastralParcel::factory()->create();
        $geom = DB::raw("(ST_GeomFromText('MULTIPOLYGON(((10 45, 11 45, 11 46, 11 46, 10 45)))'))");

        $p->landUses()->attach($lu->id, ['square_meter_surface' => 1000.0, 'geometry' => $geom]);
        $this->assertEquals(0, $p->getSurfaceByUcs(100));
    }

    /**
     * @test
     */
    public function when_parcel_single_landuse_with_coresponding_ucs_then_surface_is_partition_surface()
    {
        $lu = LandUse::factory()->create(['code' => 100]);
        $p = CadastralParcel::factory()->create();
        $geom = DB::raw("(ST_GeomFromText('MULTIPOLYGON(((10 45, 11 45, 11 46, 11 46, 10 45)))'))");

        $p->landUses()->attach($lu->id, ['square_meter_surface' => 1000.0, 'geometry' => $geom]);
        $this->assertEquals(1000.0, $p->getSurfaceByUcs(100));
    }

    /**
     * @test
     */
    public function when_parcel_multiple_landuse_with_coresponding_single_ucs_then_surface_is_partition_surface()
    {
        $lu = LandUse::factory()->create(['code' => 100]);
        $p = CadastralParcel::factory()->create();
        $geom = DB::raw("(ST_GeomFromText('MULTIPOLYGON(((10 45, 11 45, 11 46, 11 46, 10 45)))'))");
        $p->landUses()->attach($lu->id, ['square_meter_surface' => 1000.0, 'geometry' => $geom]);
        $p->landUses()->attach($lu->id, ['square_meter_surface' => 1000.0, 'geometry' => $geom]);

        $this->assertEquals(2000.0, $p->getSurfaceByUcs(100));
    }

    /**
     * @test
     */
    public function when_parcel_multiple_landuse_with_coresponding_multiple_ucs_then_surface_is_partition_surface()
    {
        $lu1 = LandUse::factory()->create(['code' => 100]);
        $lu2 = LandUse::factory()->create(['code' => 101]);
        $p = CadastralParcel::factory()->create();
        $geom = DB::raw("(ST_GeomFromText('MULTIPOLYGON(((10 45, 11 45, 11 46, 11 46, 10 45)))'))");
        $p->landUses()->attach($lu1->id, ['square_meter_surface' => 1000.0, 'geometry' => $geom]);
        $p->landUses()->attach($lu1->id, ['square_meter_surface' => 1000.0, 'geometry' => $geom]);
        $p->landUses()->attach($lu2->id, ['square_meter_surface' => 1000.0, 'geometry' => $geom]);

        $this->assertEquals(2000.0, $p->getSurfaceByUcs(100));
    }
    // public function when__then__() {}

}
