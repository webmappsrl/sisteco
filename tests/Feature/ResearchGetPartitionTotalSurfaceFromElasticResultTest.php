<?php

namespace Tests\Feature;

use App\Models\Research;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ResearchGetPartitionTotalSurfaceFromElasticResultTest extends TestCase
{
    /**
     * @test
     */
    public function when_n_hits_is_1_result_is_1000()
    {
        $n_hits = 1;
        $this->assertEquals(1000, Research::getPartitionTotalSurfaceFromElasticResult($this->_getSimpleResult($n_hits)));
    }

    /**
     * @test
     */
    public function when_n_hits_is_2_result_is_2000()
    {
        $n_hits = 2;
        $this->assertEquals(2000, Research::getPartitionTotalSurfaceFromElasticResult($this->_getSimpleResult($n_hits)));
    }

    /**
     * @test
     */
    public function when_n_hits_is_5_result_is_5000()
    {
        $n_hits = 5;
        $this->assertEquals(5000, Research::getPartitionTotalSurfaceFromElasticResult($this->_getSimpleResult($n_hits)));
    }

    /**
     * @test
     */
    public function when_n_hits_is_10_result_is_10000()
    {
        $n_hits = 10;
        $this->assertEquals(10000, Research::getPartitionTotalSurfaceFromElasticResult($this->_getSimpleResult($n_hits)));
    }


    private function _getSimpleResult(int $n_hits)
    {

        for ($i = 0; $i < $n_hits; $i++) {
            $hits[] = [
                "_index" => "particelle_uso_suolo",
                "_type" => "_doc",
                "_id" => "k18lM3kBMq6E6WdQbhtU",
                "_version" => 1,
                "_score" => 0.0,
                "fields" => [
                    "parcel_cod.NationalCadastralReference" => [
                        "B390_000100.5",
                    ],
                    "area_sub_particella" => [
                        1000,
                    ],
                ],
            ];
        }
        return [
            "took" => 23,
            "timed_out" => false,
            "_shards" => [
                "total" => 1,
                "successful" => 1,
                "skipped" => 0,
                "failed" => 0,
            ],
            "hits" => [
                "total" => [
                    "value" => 146,
                    "relation" => "eq",
                ],
                "max_score" => 0.0,
                "hits" => $hits,
            ]
        ];
    }

}
