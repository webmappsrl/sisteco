<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class LandUse extends Model {
    use HasFactory;

    public function cadastralParcels(): BelongsToMany {
        return $this->belongsToMany(CadastralParcel::class);
    }

    public function tuscanyRegionalPrices(): BelongsToMany {
        return $this->belongsToMany(TuscanyRegionalPrice::class);
    }
}
