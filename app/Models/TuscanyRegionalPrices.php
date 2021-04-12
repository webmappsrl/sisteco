<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class TuscanyRegionalPrices extends Model {
    use HasFactory;

    public function landUses(): BelongsToMany {
        return $this->belongsToMany(LandUses::class);
    }
}
