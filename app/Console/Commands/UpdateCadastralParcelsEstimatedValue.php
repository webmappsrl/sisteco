<?php

namespace App\Console\Commands;

use App\Models\CadastralParcel;
use App\Models\Municipality;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Console\Command\Command as CommandAlias;

class UpdateCadastralParcelsEstimatedValue extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sisteco:update_cadastral_parcels_estimated_value
        {--code= : Set the estimate only on the cadastral parcels with a similar code}
    ';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set the estimated value to all the cadastral parcels';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int {
        $start = 0;
        $step = 50;
        $baseQuery = CadastralParcel::orderBy('id');
        $codeFilter = $this->option('code');
        $count = CadastralParcel::count();
        if (isset($codeFilter) && !empty($codeFilter)) {
            $baseQuery = $baseQuery->where('code', 'like', "%$codeFilter%");
            $count = CadastralParcel::where('code', 'like', "%$codeFilter%")->count();
        }

        Log::info("Starting setting estimated value of the cadastral parcels");
        do {
            $cadastralParcels = $baseQuery->skip($start)->take($step)->get();
            foreach ($cadastralParcels as $cadastralParcel) {
                $cadastralParcel->estimated_value = $cadastralParcel->getTotalCost();
                $cadastralParcel->save();
            }

            $start += count($cadastralParcels);
            Log::info("Estimated value set to $start cadastral parcels");
        } while ($start < $count);

        return CommandAlias::SUCCESS;
    }
}
