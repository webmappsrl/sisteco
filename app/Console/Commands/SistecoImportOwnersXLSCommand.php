<?php

namespace App\Console\Commands;

use App\Imports\OwnerImport;
use App\Models\CadastralParcel;
use App\Models\Owner;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;

class SistecoImportOwnersXLSCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sisteco:import_owners {xls_path=: Path to xls file (in storage)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import xls OWNERS file. Find template exmaple file in storage/owners.xlsx';

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
        $collection = $collection = Excel::toCollection(new OwnerImport, storage_path($this->argument('xls_path')));
        $items = $collection[0];
        $this->info("Checking items: ".$items->count());
        $first=true;
        // Particelle	[13]												
        $fields = [
            'first_name','last_name','email','fiscal_code','vat_number','phone','business_name',
            'addr:street','addr:housenumber','addr:city','addr:postcode','addr:province','addr:locality'
        ];        
        foreach($items as $item) {
            if($first) {
                $first=false;
            }
            else {
                $owner = New Owner();
                foreach($fields as $column => $field) {
                    $this->safeSet($owner,$field,$item[$column]);
                }
                $owner->save();
                $this->info('');
                $this->info("New Owner {$owner->id}");
                foreach($fields as $field) {
                    $this->info("  $field -> {$owner->$field}");
                }     
                $this->addParticles($owner,$item[13]);

            }
        }
        return Command::SUCCESS;
    }

    private function safeSet($owner,$field,$val) {
        $owner->$field=empty($val)?'ND':$val;
    }

    private function addParticles($owner,$parcels){
        $this->info("Owner ({$owner->id}): adding parcels ($parcels)");
        if(!empty($parcels)) {
            foreach(explode(',',$parcels) as $parcel_code) {
                $parcel = CadastralParcel::where('code',trim($parcel_code))->first();
                if($parcel) {
                    // SKIP: duplicate
                    $ids = $owner->cadastralParcels()->pluck('cadastral_parcel_id')->toArray();
                    if(in_array($parcel->id,$ids)) {
                        $this->info("WARNING: NOT Attaching parcel $parcel_code to owner: parcel already attached.");
                    }
                    else {
                        $this->info("Attaching parcel $parcel_code to owner");
                        $owner->cadastralParcels()->attach($parcel->id);
                    }
                }
                else {
                    $this->info("ERROR: NOT Attaching parcel $parcel_code to owner: parcel does not exixts.");
                }
            }
        }
        else {
            $this->info("WARNING: NO PARTICLES");
        }
    }

}
