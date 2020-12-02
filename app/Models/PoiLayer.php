<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PoiLayer extends Model
{
    use HasFactory;

    protected $fillable = ['id','name','description'];


    public function pois()
    {
        return $this->hasMany(Poi::class,'layer_id');
    }
}
