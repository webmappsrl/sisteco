<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Projects extends Model {
    use HasFactory;

    public function owner(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function cadastralParcels(): BelongsToMany {
        return $this->belongsToMany(CadastralParcels::class);
    }
}
