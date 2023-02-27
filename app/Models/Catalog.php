<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Catalog extends Model
{
    use HasFactory;

    public function catalogTypes(): HasMany {
        return $this->hasMany(CatalogType::class);
    }
    public function catalogAreas(): HasMany {
        return $this->hasMany(CatalogArea::class);
    }
}
