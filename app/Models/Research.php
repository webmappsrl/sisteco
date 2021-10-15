<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Research extends Model {
    use HasFactory;

    protected $table = 'researches';

    public function cadastralParcels(): BelongsToMany {
        return $this->belongsToMany(CadastralParcel::class);
    }

    public function projects(): HasMany {
        return $this->hasMany(Project::class);
    }
}
