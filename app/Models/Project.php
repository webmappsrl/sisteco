<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property string $title
 * @property string $description
 * @property        $creator
 * @property        $research
 */
class Project extends Model {
    use HasFactory;

    protected $fillable = [
        'title', 'description'
    ];
    //    public function owners(): BelongsToMany {
    //        return $this->belongsToMany(Owner::class);
    //    }

    public function cadastralParcels(): BelongsToMany {
        return $this->belongsToMany(CadastralParcel::class);
    }

    public function creator(): BelongsTo {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function research(): BelongsTo {
        return $this->belongsTo(Research::class);
    }

    public function estimatedValue(): float {
        return array_sum($this->cadastralParcels->pluck('estimated_value')->toArray());
    }
}
