<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class CadastralParcel extends Model {
    use HasFactory;

    public function owners(): BelongsToMany {
        return $this->belongsToMany(Owner::class);
    }

    public function landUses(): BelongsToMany {
        return $this->belongsToMany(LandUse::class);
    }

    public function projects(): BelongsToMany {
        return $this->belongsToMany(Project::class);
    }
}