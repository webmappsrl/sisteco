<?php

namespace Tests\Feature;

use App\Models\CadastralParcel as ModelsCadastralParcel;
use App\Nova\CadastralParcel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CadatralParcelComputeSlopeClassTest extends TestCase
{
    use RefreshDatabase;

    public function test_values() {
/**   classe	%	gradi
 * 1 -> <=20
 * 2 -> >20 <=40
 * 3 -> >40
 */
        $values = [
            1 => 0,
            1 => 10,
            1 => 20,
            2 => 30,
            2 => 40,
            3 => 45
        ];
        foreach($values as $class => $slope) {
            $this->assertEquals($class,$this->p($slope)->computeSlopeClass());
        }

    }

    private function p($slope) {
        return ModelsCadastralParcel::factory()->create(['average_slope'=>$slope]);
    }
}
