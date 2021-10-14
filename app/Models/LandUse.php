<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class LandUses extends Model {
    use HasFactory;

    public function cadastralParcels(): BelongsToMany {
        return $this->belongsToMany(CadastralParcels::class);
    }

    public function tuscanyRegionalPrices(): BelongsToMany {
        return $this->belongsToMany(TuscanyRegionalPrices::class);
    }
}
