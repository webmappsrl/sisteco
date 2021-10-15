<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Console\Command\Command as CommandAlias;

class ImportCadastralParcels extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sisteco:import_cadastral_parcels
        {--geojson=imports/cadastral_parcels.geojson : The geojson file location}';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import all the cadastral parcels from a well formatted geojson.
        Current test file needs at least 1G of php memory limit';

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
     * @throws FileNotFoundException
     */
    public function handle(): int {
        $geojsonUri = $this->option('geojson');
        $geojson = Storage::disk('local')->get($geojsonUri);

        $geojson = json_decode($geojson, true);
        Log::info(count($geojson));

        return CommandAlias::SUCCESS;
    }
}
