<?php

namespace App\Console\Commands;

use App\Console\Crobjob\SyncElasticSearch;
use Illuminate\Console\Command;

class SyncUpdatedDataESCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'es:updated';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync updated data from database to elastic search';

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
        $es_sync = new SyncElasticSearch();
        $es_sync->syncUpdatedProduct();
        $es_sync->syncUpdatedCategory();
        $es_sync->syncUpdatedBrand();
    }
}
