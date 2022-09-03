<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Owner extends Model {

    protected $fillable = [
        'first_name','last_name','email'
    ];
    use HasFactory;

    public function cadastralParcels(): BelongsToMany {
        return $this->belongsToMany(CadastralParcel::class);
    }

    //    public function projects(): BelongsToMany {
    //        return $this->belongsToMany(Project::class);
    //    }
}
