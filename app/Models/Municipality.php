<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Municipality extends Model
{
    use HasFactory;

    public function cadastralParcels()
    {
        return $this->hasMany(CadastralParcel::class);
    }

    protected $fillable =
        ['code', 'name'];
}
