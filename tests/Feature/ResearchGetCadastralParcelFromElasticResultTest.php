<?php

namespace Tests\Feature;

use App\Models\Research;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ResearchGetCadastralParcelFromElasticResultTest extends TestCase
{
    /**
     * @test
     */
    public function when_result_is_simple_then_count_is_2()
    {
        $parcels = Research::getCadastralParcelFromElasticResult($this->simpleResult);
        $this->assertEquals(2, count($parcels));
    }

    /**
     * @test
     */
    public function when_result_is_simple_then_it_contains_B390_000100p5()
    {
        $parcels = Research::getCadastralParcelFromElasticResult($this->simpleResult);
        $this->assertContains('B390_000100.5', $parcels);
    }

    /**
     * @test
     */
    public function when_result_is_simple_then_it_contains_B390_000100p4()
    {
        $parcels = Research::getCadastralParcelFromElasticResult($this->simpleResult);
        $this->assertContains('B390_000100.4', $parcels);
    }

    private $simpleResult =
        [
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
                "hits" => [
                    [
                        "_index" => "particelle_uso_suolo",
                        "_type" => "_doc",
                        "_id" => "k18lM3kBMq6E6WdQbhtU",
                        "_version" => 1,
                        "_score" => 0.0,
                        "fields" => [
                            "parcel_cod.NationalCadastralReference" => [
                                "B390_000100.5",
                            ],
                        ],
                    ],
                    [
                        "_index" => "particelle_uso_suolo",
                        "_type" => "_doc",
                        "_id" => "s18lM3kBMq6E6WdQbRof",
                        "_version" => 1,
                        "_score" => 0.0,
                        "fields" => [
                            "parcel_cod.NationalCadastralReference" => [
                                "B390_000100.4",
                            ],
                        ],
                    ],
                    [
                        "_index" => "particelle_uso_suolo",
                        "_type" => "_doc",
                        "_id" => "s18lM3kBMq6E6WdQbRof",
                        "_version" => 1,
                        "_score" => 0.0,
                        "fields" => [
                            "parcel_cod.NationalCadastralReference" => [
                                "B390_000100.4",
                            ],
                        ],
                    ],
                ]
            ]
        ];
}
