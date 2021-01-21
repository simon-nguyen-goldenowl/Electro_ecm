<?php

namespace App\Console\Commands;

use App\Console\Crobjob\SyncElasticSearch;
use Illuminate\Console\Command;

class SyncCreatedDataESCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'es:Created';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync created data from database to elastic search';

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
        $es_sync->indexProductDocument();
        $es_sync->indexBrandDocument();
        $es_sync->indexCategoryDocument();
    }
}
