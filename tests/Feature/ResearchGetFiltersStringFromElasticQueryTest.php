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

    /**
     * @test
     */
    public function when_query_is_real_then_it_matches_ucs2013_210()
    {
        $filters = Research::getFiltersStringFromElasticQuery($this->realQuery);
        $this->assertMatchesRegularExpression('/ucs2013:210/', $filters);
    }

    /**
     * @test
     */
    public function when_query_is_real_then_it_matches_exaclty()
    {
        $filters = Research::getFiltersStringFromElasticQuery($this->realQuery);
        $expected = 'geometry,ucs2013:210';
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

    private $realQuery = <<<EOF
{
  "size": 500,
  "sort": [
    {
      "_score": {
        "order": "desc"
      }
    }
  ],
  "version": true,
  "fields": [
    {
      "field": "*",
      "include_unmapped": "true"
    }
  ],
  "script_fields": {},
  "stored_fields": [
    "*"
  ],
  "runtime_mappings": {},
  "_source": false,
  "query": {
    "bool": {
      "must": [],
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
                "type": "Polygon",
                "coordinates": [
                  [
                    [
                      10.40251,
                      43.82125
                    ],
                    [
                      10.40251,
                      43.80938
                    ],
                    [
                      10.42006,
                      43.80938
                    ],
                    [
                      10.42006,
                      43.82125
                    ],
                    [
                      10.40251,
                      43.82125
                    ]
                  ]
                ]
              }
            }
          }
        },
        {
          "match_phrase": {
            "ucs2013": "210"
          }
        }
      ],
      "should": [],
      "must_not": []
    }
  },
  "highlight": {
    "pre_tags": [
      "@kibana-highlighted-field@"
    ],
    "post_tags": [
      "@/kibana-highlighted-field@"
    ],
    "fields": {
      "*": {}
    },
    "fragment_size": 2147483647
  }
}
EOF;


}
