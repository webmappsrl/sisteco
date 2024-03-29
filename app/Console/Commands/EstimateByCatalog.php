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
        $types = $c->catalogTypes()->pluck('code_int','id')->toArray(); 
        $prices = $c->catalogTypes()->pluck('prices','code_int')->toArray(); 

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
            // SLOPE AND DISTANCE
            $parcel_code = $p->computeSlopeClass().'.'.$p->computeTransportClass();
            $total_price = 0;
            $json = [];
            if(count($results)>0) {
                $items = [];
                $count = count($results);
                $this->info("Found $count intersections");
                foreach($results as $item) {
                    $code_int = $types[$item->catalog_type_id];
                    $unit_price = $prices[$code_int][$parcel_code];
                    $price = $item->area / 10000 * $unit_price;
                    $total_price += $price;
                    $items[]=[
                        'code' => $code_int.'.'.$parcel_code,
                        'area' => number_format($item->area / 10000,4,',','.'),
                        'unit_price' => number_format($unit_price,2,',','.'),
                        'price' => number_format($price,2,',','.'),
                    ];
                }
                $json = [
                    'items' => $items,
                    'price' => number_format($total_price,2,',','.')
                ];
                $p->catalog_estimate=$json;
                $p->estimated_value=$total_price;
                $this->info(json_encode($json));
                $p->save();
            } else {
                $this->info("No intersection Found");
            }
            $this->info('---');
        }
        return Command::SUCCESS;
    }
}
