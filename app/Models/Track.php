<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Track extends Model
{
    use HasFactory;

    protected $fillable = ['id','name','description','layer_id','properties','geometry'];


    public function TrackLayer()
    {
        return $this->belongsTo(TrackLayer::class);
    }
}
