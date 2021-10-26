<?php

namespace App\Console\Commands;

use App\Models\CadastralParcel;
use App\Models\Municipality;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Console\Command\Command as CommandAlias;

class UpdateCadastralParcelsMunicipality extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sisteco:update_cadastral_parcels_municipality';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set a the municipality to all the cadastral parcels';

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

        Log::info("Starting setting municipality to the cadastral parcels");
        do {
            $cadastralParcels = CadastralParcel::orderBy('id')->skip($start)->take($step)->get();
            foreach ($cadastralParcels as $cadastralParcel) {
                $mun = Municipality::where('code', explode('_', $cadastralParcel->code)[0])->first();
                if (!is_null($mun)) {
                    $cadastralParcel->municipality_id = $mun->id;
                }
                $cadastralParcel->save();
            }

            $start += count($cadastralParcels);
            Log::info("Municipality set to $start cadastral parcels");
        } while ($start < CadastralParcel::count());

        return CommandAlias::SUCCESS;
    }
}
