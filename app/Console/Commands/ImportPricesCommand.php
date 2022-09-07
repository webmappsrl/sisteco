<?php

namespace App\Console\Commands;

use App\Imports\PricesImport;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;

class ImportPricesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sisteco:import-prices';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Imnport file storage/app/imports/prices.xlsx';

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
        $this->output->title('Import started');
        Excel::import(new PricesImport,storage_path('/app/imports/prices.xlsx'));
        //(new PricesImport)->withOutput($this->output)->import(storage_path('/app/imports/prices.xlsx'));
        $this->output->success('Import completed');
        return Command::SUCCESS;
    }
}
