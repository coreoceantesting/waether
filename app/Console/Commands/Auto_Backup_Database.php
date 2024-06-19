<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;

class Auto_Backup_Database extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'database:backup';

    /**
     * The console command description.
     *
     * @var string
     */
    public function __construct()
    {
        parent::__construct();
    }
    
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $filename = "backup-" . Carbon::now()->format('d-m-Y') . ".gz";
  
        $command = "mysqldump --no-tablespaces --user=" . env('DB_USERNAME') ." --password=" . env('DB_PASSWORD') . " --host=" . env('DB_HOST') . " " . env('DB_DATABASE') . "  | gzip > " . storage_path() . "/app/database-backup/" . $filename;
        echo $command;
        // $command = "mysqldump -u ".env('DB_USERNAME')." –p ".env('DB_PASSWORD')." -h ".env('DB_HOST')." --all ".env('DB_DATABASE')."  > " . storage_path() . "/app/database-backup/" . $filename;
        $returnVar = NULL;
        $output  = NULL;
  
        exec($command, $output, $returnVar);
    }
}
