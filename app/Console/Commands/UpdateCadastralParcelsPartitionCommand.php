<?php

namespace App\Console\Commands;

use App\Models\CadastralParcel;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;


class UpdateCadastralParcelsPartitionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sisteco:update_partitions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Loop all cadastral Parcels and update partitions surface';

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
        Log::info("Update partions surfaces");
        $offset = 0;
        $p = CadastralParcel::orderby('id')->limit(10)->offset($offset)->get();
        while($p->count()>0) {
            foreach($p as $parcel) {
                Log::info("Processing {$parcel->id}");
                $parcel->partitions = [
                    '223' => $parcel->getSurfaceByUcs(223),
                ];
                $parcel->save();
            }
            $offset += 10;
            $p = CadastralParcel::orderby('id')->limit(10)->offset($offset)->get();
        }
        return Command::SUCCESS;
    }
}
