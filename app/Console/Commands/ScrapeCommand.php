<?php

namespace App\Console\Commands;

use App\Scraper\Laptop;
use App\Scraper\Smartphone;
use Illuminate\Console\Command;

class ScrapeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scrape:product';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scrape smartphone data from ecommerce';

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
        $botPhone = new Smartphone();
        $botPhone->handle();
        $botLaptop = new Laptop();
        $botLaptop->handle();
    }
}
