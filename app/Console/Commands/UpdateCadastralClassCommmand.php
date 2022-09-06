<?php

namespace App\Console\Commands;

use App\Models\CadastralParcel;
use App\Models\Owner;
use Illuminate\Console\Command;

class UpdateCadastralClassCommmand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sisteco:update-class';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update slope and transport class';

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
        $this->output->title('Updating class of all particles belonging to some owner');
        $os = Owner::all();
        foreach($os as $o) {
            $this->output->info('Owner '.$o->last_name);
            foreach ($o->cadastralParcels as $p) {
                $this->output->text('   -> Updating Parcel '.$p->code);
                $p->slope=$p->computeSlopeClass();
                $p->way=$p->computeTransportClass();
                $p->save();
            }
        }
        return Command::SUCCESS;
    }
}
