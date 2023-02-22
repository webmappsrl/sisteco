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
        $types = $c->catalogTypes()->pluck('code','id')->toArray(); 
        $prices = $c->catalogTypes()->pluck('price','id')->toArray(); 

        $this->info('Processing');
        $ids = collect(DB::select('select distinct cadastral_parcel_id as id from cadastral_parcel_owner;'))->pluck('id')->toArray();

        $parcels = CadastralParcel::whereIn('id',$ids)->get();
        $tot_p = $parcels->count();
        $count_p = 1;
        // Loop on particles
        foreach($parcels as $p) {
            $this->info("($count_p/$tot_p)Processing cadastral parcel {$p->id}");
            $count_p++;
            $results = DB::select("
                        SELECT 
                            catalog_type_id, 
                            SUM(ST_AREA(ST_Intersection(a.geometry,p.geometry))) as area 

                        FROM 
                           cadastral_parcels as p, 
                           catalog_areas as a

                        WHERE 
                           a.catalog_id={$this->argument('id')} AND 
                           p.id = {$p->id} 
                           AND ST_Intersects(a.geometry,p.geometry)
                           
                        GROUP BY
                           catalog_type_id
                           ");
            
            if(count($results)>0) {
                $json = [];
                $count = count($results);
                $this->info("Found $count intersections");
                // TODO: Save data into cadastral particles
                foreach($results as $item) {
                    $json[]=[
                        'code' => $types[$item->catalog_type_id],
                        'area' => $item->area,
                        'unit_price' => $prices[$item->catalog_type_id],
                        'price' => $item->area * $prices[$item->catalog_type_id],
                    ];
                }
                $p->catalog_estimate=$json;
                $p->save();
            } else {
                $this->info("No intersection Found");
            }
            $this->info('---');
        }
        return Command::SUCCESS;
    }
}
