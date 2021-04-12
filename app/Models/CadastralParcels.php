<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class CadastralParcels extends Model {
    use HasFactory;

    public function clients(): BelongsToMany {
        return $this->belongsToMany(Clients::class);
    }

    public function landUses(): BelongsToMany {
        return $this->belongsToMany(LandUses::class);
    }

    public function projects(): BelongsToMany {
        return $this->belongsToMany(Projects::class);
    }
}
