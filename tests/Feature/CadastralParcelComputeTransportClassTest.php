<?php

namespace Tests\Feature;

use App\Models\CadastralParcel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CadastralParcelComputeTransportClassTest extends TestCase
{
    use RefreshDatabase;

    public function test_values() {
/**   classe	%	gradi
 * 1 -> <=500
 * 2 -> >500 <=1000
 * 3 -> >1000
 */
        $values = [
            1 => 0,
            1 => 250,
            1 => 500,
            2 => 750,
            2 => 1000,
            3 => 1500
        ];
        foreach($values as $class => $dist) {
            $this->assertEquals($class,$this->p($dist)->computeTransportClass());
        }

    }

    private function p($dist) {
        return CadastralParcel::factory()->create(['meter_min_distance_road'=>$dist]);
    }

}
