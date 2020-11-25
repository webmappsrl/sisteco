<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;

    protected $fillable = ['id','name','description','layer_id','properties','geometry'];

    public function AreaLayer()
    {
        return $this->belongsTo(AreaLayer::class);
    }
}
