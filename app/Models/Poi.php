<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use MStaack\LaravelPostgis\Eloquent\PostgisTrait;

class Poi extends Model
{
    use HasFactory;
    use PostgisTrait;


    protected $fillable = ['id','name','description','layer_id','properties'];

     protected $postgisFields = [
         'geometry',
     ];

     protected $postgisTypes = [
         'geometry' => [
             'geomtype' => 'geography',
             'srid' => 4326
         ]
     ];

    public function poiLayer()
    {
        return $this->belongsTo(PoiLayer::class,'layer_id');
    }
}
