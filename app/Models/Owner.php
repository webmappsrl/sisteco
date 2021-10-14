<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Owner extends Model {
    use HasFactory;

    public function cadastralParcels(): BelongsToMany {
        return $this->belongsToMany(CadastralParcel::class);
    }
}