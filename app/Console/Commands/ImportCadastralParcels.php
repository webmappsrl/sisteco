<?php

namespace App\Console\Commands;

use Exception;
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
     * @param string $dbHost
     * @param string $dbPort
     * @param string $dbName
     * @param string $dbUser
     * @param string $dbPassword
     * @param string $tableName
     * @param string $geojsonPath
     *
     * @throws Exception
     */
    public function importWithOgr2Ogr(string $dbHost, string $dbPort, string $dbName, string $dbUser, string $dbPassword, string $tableName, string $geojsonPath): void {
        if (!$this->ogr2ogrExists())
            throw new Exception('The ogr2ogr command is needed to import the geojson. The execution cannot continue');

        Log::info("Running ogr2ogr import");
        $command = "ogr2ogr -f PostgreSQL PG:\"dbname='$dbName' host='$dbHost' port='$dbPort' user='$dbUser' password='$dbPassword'\" $geojsonPath -nln $tableName";
        system($command);

        if (!Schema::hasTable($tableName))
            throw new Exception('The ogr2ogr import went wrong. The import table could not be found');

        Log::info("Ogr2ogr import completed");
    }

    /**
     * Import all the cadastral parcels from the support import table
     *
     * @param string $tableName the support import table name
     *
     * @throws Exception
     */
    public function importCadastralParcels(string $tableName): void {
        try {
            Log::info("Importing cadastral parcels");
            DB::statement("INSERT INTO cadastral_parcels (code, geometry, created_at, updated_at)
            SELECT
                cadastral_parcel_id,
                ST_Union(geometry),
                NOW(),
                NOW()
            FROM
                (SELECT
                    id,
                    REPLACE(
                        (parcel_cod::json->'NationalCadastralReference')::text,
                        '\"',
                        ''
                    ) as cadastral_parcel_id,
                    wkb_geometry as geometry
                FROM $tableName) as cadastral_parcels_table
            GROUP BY cadastral_parcels_table.cadastral_parcel_id;
        ");
        } catch (Exception $e) {
            throw new Exception("The cadastral parcels could not be imported correctly. Error: " . $e->getMessage());
        }
        Log::info("Cadastral parcels import completed");
    }

    /**
     * Import all the land uses of the imported cadastral parcels from the support import table
     *
     * @param string $tableName the support import table name
     *
     * @throws Exception
     */
    public function importLandUsesOfCadastralParcels(string $tableName): void {
        try {
            Log::info("Importing land uses of cadastral parcels");
            DB::statement("INSERT INTO cadastral_parcel_land_use
                (cadastral_parcel_id, land_use_id, geometry, square_meter_surface, created_at, updated_at)
                SELECT
                    cadastral_parcels.id as cadastral_parcel_id,
                    COALESCE(land_uses.id, other_land_use_id.id) as land_use_id,
                    wkb_geometry as geometry,
                    area_sub_p as square_meter_surface,
                    NOW(),
                    NOW()
                FROM
                    $tableName LEFT OUTER JOIN land_uses ON (
                        $tableName.ucs2013 = land_uses.code
                    ) LEFT OUTER JOIN cadastral_parcels ON (
                        REPLACE(
                            ($tableName.parcel_cod::json->'NationalCadastralReference')::text,
                            '\"',
                            ''
                        ) = cadastral_parcels.code::text
                    ),
                    (SELECT id FROM land_uses WHERE code = '000') as other_land_use_id;
        ");
        } catch (Exception $e) {
            throw new Exception("The sub cadastral parcels could not be imported correctly. Error: " . $e->getMessage());
        }
        Log::info("Land uses of cadastral parcels import completed");
    }

    /**
     * Clean the database from the import table(s)
     */
    public function deleteImportTables(): void {
        Log::info("Deleting support import table(s)");
        $tables = DB::select("SELECT tablename
            FROM pg_catalog.pg_tables
            WHERE schemaname = 'public';
        ");
        foreach ($tables as $table) {
            if (substr($table->tablename, 0, 31) == 'cadastral_parcels_import_table_')
                Schema::dropIfExists($table->tablename);
        }
        Log::info("Support import table(s) deleted");
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int {
        $geojsonUri = $this->option('geojson');
        $geojsonFullPath = Storage::disk('local')->path($geojsonUri);
        $dbHost = config('database.connections.' . config('database.default') . '.host');
        $dbPort = config('database.connections.' . config('database.default') . '.port');
        $dbName = config('database.connections.' . config('database.default') . '.database');
        $dbUser = config('database.connections.' . config('database.default') . '.username');
        $dbPassword = config('database.connections.' . config('database.default') . '.password');
        $tableName = "cadastral_parcels_import_table_" . substr(str_shuffle(MD5(microtime())), 0, 5);

        DB::beginTransaction();

        try {
            Log::info('Cleaning current cadastral parcels');
            DB::table('cadastral_parcel_land_use')->truncate();
            DB::table('cadastral_parcels')->truncate();

            if (!Storage::disk('local')->exists($geojsonUri))
                throw new Exception("The geojson file could not be found in $geojsonFullPath");

            $this->importWithOgr2Ogr($dbHost, $dbPort, $dbName, $dbUser, $dbPassword, $tableName, $geojsonFullPath);

            $this->importCadastralParcels($tableName);
            $this->importLandUsesOfCadastralParcels($tableName);
        } catch (Exception $e) {
            DB::rollBack();
            Log::critical($e->getMessage());

            $this->deleteImportTables();

            return CommandAlias::FAILURE;
        }

        $this->deleteImportTables();

        DB::commit();

        return CommandAlias::SUCCESS;
    }
}
