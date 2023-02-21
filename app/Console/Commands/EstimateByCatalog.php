<?php

namespace App\Console\Commands;

use App\Models\CadastralParcel;
use App\Models\Catalog;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class EstimateByCatalog extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sisteco:estimate_by_catalog
                            {id : id of the catalog that must be used to estimate}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command loop on all cadastral particles and compute the estimated value on a specific catalog identified by id';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Find Catalog
        $c = Catalog::find($this->argument('id'));
        if(empty($c)) {
            throw new Exception("Catalog with ID {$this->argument('id')} does not exist..", 1);
            
        }
        $this->info('Processing');

        // Loop on particles
        foreach(CadastralParcel::all() as $p) {
            $this->info("Processing cadastral parcel {$p->id}");
            $results = DB::select("
                        SELECT 
                            a.id, 
                            ST_AREA(ST_Intersection(a.geometry,p.geometry)) as area 

                        FROM 
                           cadastral_parcels as p, 
                           catalog_areas as a

                        WHERE 
                           a.catalog_id={$this->argument('id')} AND 
                           p.id = {$p->id} 
                           AND ST_Intersects(a.geometry,p.geometry)");
            
            if(count($results)>0) {
                $count = count($results);
                $this->info("Found $count intersections");
            } else {
                $this->info("No intersection Found");
            }
            $this->info('---');
        }
        return Command::SUCCESS;
    }
}
