<?php

namespace Tests\Feature;

use App\Models\Research;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ResearchGetFiltersStringFromElasticQueryTest extends TestCase
{

    /**
     * @test
     */
    public function when_query_is_null_then_filters_is_null()
    {
        $this->assertEmpty(Research::getFiltersStringFromElasticQuery(null));
    }

    /**
     * @test
     */
    public function when_query_is_simple_then_it_matches_geometry()
    {
        $filters = Research::getFiltersStringFromElasticQuery($this->simpleQuery);
        $this->assertMatchesRegularExpression('/geometry/', $filters);
    }

    /**
     * @test
     */
    public function when_query_is_simple_then_it_matches_ucs2013_313()
    {
        $filters = Research::getFiltersStringFromElasticQuery($this->simpleQuery);
        $this->assertMatchesRegularExpression('/ucs2013:313/', $filters);
    }

    /**
     * @test
     */
    public function when_query_is_simple_then_it_matches_comune_CALCI()
    {
        $filters = Research::getFiltersStringFromElasticQuery($this->simpleQuery);
        $this->assertMatchesRegularExpression('/comune:CALCI/', $filters);
    }

    /**
     * @test
     */
    public function when_query_is_simple_then_it_matches_exaclty()
    {
        $filters = Research::getFiltersStringFromElasticQuery($this->simpleQuery);
        $expected = 'geometry,ucs2013:313,comune:CALCI';
        $this->assertEquals($expected, $filters);
    }

    private $simpleQuery = <<<EOF
{
  "query": {
    "bool": {
      "filter": [
        {
          "match_all": {}
        },
        {
          "geo_shape": {
            "ignore_unmapped": true,
            "geometry": {
              "relation": "WITHIN",
              "shape": {
                "coordinates": [
                  [
                    [
                      10.52248,
                      43.73937
                    ],
                    [
                      10.50563,
                      43.75521
                    ]
                  ]
                ],
                "type": "Polygon"
              }
            }
          }
        },
        {
          "match_phrase": {
            "ucs2013": "313"
          }
        },
        {
          "match_phrase": {
            "comune": "CALCI"
          }
        }
      ],
      "should": [],
      "must_not": []
    }
  }
}
EOF;


}
