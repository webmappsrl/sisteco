<?php

namespace App\Console\Commands;

use App\Models\CadastralParcel;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Console\Command\Command as CommandAlias;

class UpdateCadastralParcelsEstimatedValue extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sisteco:update_cadastral_parcels_estimated_value';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set a random value to all the cadastral parcels with a number between 10 and 10000';

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
        $step = 10000;

        Log::info("Starting setting random values to the estimated value of the cadastral parcels");
        while ($start < CadastralParcel::count()) {
            $cadastralParcels = CadastralParcel::skip($start)->take($step)->get();
            foreach ($cadastralParcels as $cadastralParcel) {
                $cadastralParcel->estimated_value = rand(10, 10000);
                $cadastralParcel->save();
            }

            $start += count($cadastralParcels);
            Log::info("Estimated value set to $start cadastral parcels");
        }

        return CommandAlias::SUCCESS;
    }
}
