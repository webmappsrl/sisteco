<?php

namespace App\Providers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class ElasticServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(ElasticServiceProvider::class, function ($app) {
            return new ElasticServiceProvider($app);
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Test in tinker:
     * How to test by tinker
     * shell> php artisan tinker
     * tinker>>> $elastic = app(App\Providers\ElasticServiceProvider::class);
     * tinker>>> $elastic->query($elastic->getTestQuery());
     *
     * @param string $body
     * @return array
     */
    public function query(string $body): array
    {
        if (empty($body)) return [];

        $ch = curl_init(config('sisteco.elastic_url'));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_USERPWD, config('sisteco.elastic_user') . ":" . config('sisteco.elastic_password'));
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $out = curl_exec($ch);
        curl_close($ch);
        return json_decode($out, true);
    }

    /**
     * Use it for testing purposes (fields: "parcel_cod.NationalCadastralReference")
     *
     * @return string
     */
    public static function getTestQuery(): string
    {
        return <<<EOF
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
    "parcel_cod.NationalCadastralReference"
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
                "coordinates": [
                  [
                    [
                      10.52248,
                      43.73937
                    ],
                    [
                      10.50563,
                      43.75521
                    ],
                    [
                      10.52028,
                      43.75963
                    ],
                    [
                      10.53025,
                      43.75993
                    ],
                    [
                      10.53465,
                      43.75804
                    ],
                    [
                      10.53575,
                      43.75318
                    ],
                    [
                      10.53314,
                      43.74642
                    ],
                    [
                      10.53307,
                      43.74339
                    ],
                    [
                      10.52248,
                      43.73937
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
}
