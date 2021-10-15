<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
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
        Current test file needs at least 5G of php memory limit';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Check if the ogr2ogr command exists
     *
     * @return bool
     */
    public function ogr2ogrExists(): bool {
        $return = shell_exec("which ogr2ogr");

        return !empty($return);
    }

    /**
     * Import the geojson in the database
     *
     * @param string $dbName
     * @param string $tableName
     * @param string $geojsonPath
     *
     * @return int
     */
    public function importWithOgr2Ogr(string $dbName, string $tableName, string $geojsonPath): int {
        if (!$this->ogr2ogrExists()) {
            Log::critical('The ogr2ogr command is needed to import the geojson. The execution cannot continue');

            return CommandAlias::FAILURE;
        }

        Log::info("Running ogr2ogr import");
        $command = "ogr2ogr -f PostgreSQL PG:\"dbname=$dbName\" $geojsonPath -nln $tableName";
        system($command);

        if (!Schema::hasTable($tableName)) {
            Log::critical('The ogr2ogr import went wrong. The import table could not be found');

            return CommandAlias::FAILURE;
        }

        Log::info("Ogr2ogr import completed");

        return CommandAlias::SUCCESS;
    }

    /**
     * Clean the database from the import table
     *
     * @param string $tableName
     */
    public function deleteImportTable(string $tableName): void {
        Log::info("Deleting import table");
        Schema::dropIfExists($tableName);
        Log::info("Import table deleted");
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int {
        $geojsonUri = $this->option('geojson');
        $geojsonFullPath = Storage::disk('local')->path($geojsonUri);
        $dbName = config('database.connections.' . config('database.default') . '.database');
        $tableName = "cadastral_parcels_import_table_" . substr(str_shuffle(MD5(microtime())), 0, 5);

        $result = $this->importWithOgr2Ogr($dbName, $tableName, $geojsonFullPath);
        if ($result !== CommandAlias::SUCCESS)
            return $result;

        $this->deleteImportTable($tableName);

        return CommandAlias::SUCCESS;
    }
}
