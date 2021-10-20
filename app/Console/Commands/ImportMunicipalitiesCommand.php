<?php

namespace App\Console\Commands;

use App\Models\Municipality;
use Illuminate\Console\Command;

class ImportMunicipalitiesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sisteco:import_municipalities';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import municipalities form file storage/app/imports/lisacomuni.txt: download it from http://lab.comuni-italiani.it/files/listacomuni.zip';

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
     * Array
     * (
     * [0] => Istat
     * [1] => Comune
     * [2] => Provincia
     * [3] => Regione
     * [4] => Prefisso
     * [5] => CAP
     * [6] => CodFisco
     * [7] => Abitanti
     * [8] => Link
     * )
     *
     * @return int
     */
    public function handle()
    {
        $filename = storage_path() . '/app/imports/listacomuni.txt';
        $file = fopen($filename, 'r');
        while (($line = fgetcsv($file, 0, ';')) !== FALSE) {
            if ($line[3] == 'TOS') {
                Municipality::firstOrCreate(['name' => utf8_encode($line[1]), 'code' => $line[6]]);
            }

        }
        fclose($file);


        return Command::SUCCESS;
    }
}
