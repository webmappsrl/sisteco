<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

/**
 * @property float square_meter_surface
 */
class CadastralParcel extends Model
{
    use HasFactory;

    public function owners(): BelongsToMany
    {
        return $this->belongsToMany(Owner::class);
    }

    public function landUses(): BelongsToMany
    {
        return $this->belongsToMany(LandUse::class)->withPivot('square_meter_surface');
    }

    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class);
    }

    public function researches(): BelongsToMany
    {
        return $this->belongsToMany(Research::class);
    }

    public function municipality(): BelongsTo
    {
        return $this->belongsTo(Municipality::class);
    }

    /**
     * @param string $ucs
     * @return float
     */
    public function getSurfaceByUcs(string $ucs): float
    {
        if ($this->landUses()->count() == 0) {
            return 0;
        }
        $ucs_codes = $this->landUses()->pluck('code')->toArray();
        if (!in_array($ucs, $ucs_codes)) {
            return 0;
        }

        $surfaces = $this->landUses()->where('code', $ucs)->pluck('square_meter_surface')->toArray();
        return array_sum($surfaces);
    }

    /**
     * @param int $year
     * @return Collection
     */
    public function getCostsByYear(int $year): Collection
    {

        if ($year == 1) {
            $c = new Collection();
            $tot = 0;

            // Header
            $row = ['Voce di Costo', 'U.M.', 'Quantità', 'Costo Un. €', 'Costo Tot. €'];
            $c->add($row);

            // Taglio raso Conifere
            $cost = $this->getSurfaceByUcs(312) / 10000 * 5870;
            $tot += $cost;
            $row = [
                'Taglio raso fascia di conifere adiacente alla strada (ucs2013: 312)',
                'ha',
                number_format($this->getSurfaceByUcs(312) / 10000, 4, ',', '.'),
                '5.870,00 €/ha',
                number_format($cost, 2, ',', '.')
            ];
            $c->add($row);

            // Diradamento di conifere
            $cost = $this->getSurfaceByUcs(312) / 10000 * 5920;
            $tot += $cost;
            $row = [
                'Diradamento di conifere comprensivo di abbattimento e accatastamento in loco del abbattimento e accatastamento in loco del materiale di risulta (ucs2013: 312)',
                'ha',
                number_format($this->getSurfaceByUcs(312) / 10000, 4, ',', '.'),
                '5.920,00 €/ha',
                number_format($cost, 2, ',', '.')
            ];
            $c->add($row);

            // TOTALE
            $row = [
                'TOTALE Anno1',
                '',
                '',
                '',
                number_format($tot, 2, ',', '.')
            ];
            $c->add($row);
        } else {
            $c = new Collection();
            $tot = 0;

            // Header
            $row = ['Voce di Costo', 'U.M.', 'Quantità', 'Costo Un. €', 'Costo Tot. €'];
            $c->add($row);

            // Taglio raso Conifere
            $cost = 0;
            $tot += $cost;
            $row = [
                'Taglio raso fascia di conifere adiacente alla strada (ucs2013: 312)',
                'ha',
                '0,0',
                '5.870,00 €/ha',
                number_format($cost, 2, ',', '.')
            ];
            $c->add($row);

            // Diradamento di conifere
            $cost = 0;
            $tot += $cost;
            $row = [
                'Diradamento di conifere comprensivo di abbattimento e accatastamento in loco del abbattimento e accatastamento in loco del materiale di risulta (ucs2013: 312)',
                'ha',
                '0,0',
                '5.920,00 €/ha',
                number_format($cost, 2, ',', '.')
            ];
            $c->add($row);

            // TOTALE
            $row = [
                'TOTALE Anno1',
                '',
                '',
                '',
                number_format($tot, 2, ',', '.')
            ];
            $c->add($row);
        }


        return $c;
    }

    public function getGlobalCostsArray(): array
    {
        return [
            $this->getSurfaceByUcs(312) / 10000 * (5920 + 5870),
            0,
            0,
            0,
            0
        ];
    }

    public function getTotalCost()
    {
        return array_sum($this->getGlobalCostsArray());
    }

    public function getGlobalCosts(): Collection
    {
        $c = new Collection();
        $c->add(['Riassuntivo']);
        $year = 1;
        foreach ($this->getGlobalCostsArray() as $cost_by_year) {
            $c->add(['Anno ' . $year, $cost_by_year]);
            $year++;
        }
        $c->add(['Totale', $this->getTotalCost()]);
        return $c;
    }
}
