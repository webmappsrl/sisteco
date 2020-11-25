<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AreaLayer extends Model
{
    use HasFactory;

    protected $fillable = ['id','name','description'];

    public function Area()
    {
        return $this->hasMany(Area::class);
    }
}
