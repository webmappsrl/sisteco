<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Research extends Model
{
    use HasFactory;

    protected $table = 'researches';

    protected $fillable = [
        'filters'
    ];

    public function cadastralParcels(): BelongsToMany
    {
        return $this->belongsToMany(CadastralParcel::class);
    }

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    public static function getFiltersStringFromElasticQuery($query)
    {
        if (empty($query)) return '';
        $j = json_decode($query, true);
        $filters_array = [];
        foreach ($j['query']['bool']['filter'] as $filters) {
            if (array_key_exists('geo_shape', $filters)) {
                $filters_array[] = 'geometry';
            } else if (array_key_exists('match_phrase', $filters)) {
                foreach ($filters['match_phrase'] as $k => $v) {
                    $filters_array[] = "$k:$v";
                }
            }
        }
        return implode(',', $filters_array);
    }

    /**
     * It returns array of casdatral parcel identification code
     *
     * @param array $result
     * @return array
     */
    public static function getCadastralParcelFromElasticResult(array $result): array
    {
        $parcels = [];
        if (isset($result['hits'])
            && isset($result['hits']['hits'])
            && count($result['hits']['hits']) > 0) {
            foreach ($result['hits']['hits'] as $hit) {
                if (isset($hit['fields']['parcel_cod.NationalCadastralReference'])) {
                    $parcels[] = $hit['fields']['parcel_cod.NationalCadastralReference'][0];
                }
            }
        }
        return array_unique($parcels);
    }
}
