<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Command\Command as CommandAlias;

class ImportCadastralParcels extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sisteco:import_cadastral_parcels';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import all the cadastral parcels from a well formatted geojson.
        By default it searches the geojson in storage/app/imports/cadastral_parcels.geojson';

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
        return CommandAlias::SUCCESS;
    }
}
