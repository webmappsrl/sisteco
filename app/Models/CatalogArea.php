<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatalogArea extends Model
{
    use HasFactory;

    protected $fillable = [
        'geometry',
        'catalog_id',
        'catalog_type_id'
    ];
}
