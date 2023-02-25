<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CatalogType extends Model
{
    use HasFactory;

    protected $casts = [
        'prices' => 'array',
    ] ;

    /**
     * Returns the corresponding catalog
     *
     * @return BelongsTo
     */
    public function catalog(): BelongsTo {
        return $this->belongsTo(Catalog::class);
    }
}
