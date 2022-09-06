<?php

namespace App\Console\Commands;

use App\Models\CadastralParcel;
use App\Models\Municipality;
use App\Models\Owner;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Console\Command\Command as CommandAlias;

class UpdateCadastralParcelsEstimatedValue extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sisteco:update-cadastral-parcels-estimate';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set the estimated value to all the cadasatral parcels belonging to some owners';

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
        $this->output->title('Updating estimated value of all particles belonging to some owner');
        $os = Owner::all();
        foreach($os as $o) {
            $this->output->info('Owner '.$o->last_name);
            foreach ($o->cadastralParcels as $p) {
                $this->output->text('   -> Updating Parcel '.$p->code);
                $p->estimated_value=$p->computeEstimate();
                $p->save();
            }
        }
        return Command::SUCCESS;
    }
    
}
