<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackLayer extends Model
{
    use HasFactory;

    protected $fillable = ['id','name','description'];


    public function Track()
    {
        return $this->hasMany(Track::class);
    }
}
