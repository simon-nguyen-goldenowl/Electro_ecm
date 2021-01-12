<?php

namespace App\Console\Commands;

use App\Models\CrawlProduct;
use App\Models\Product;
use Illuminate\Console\Command;

class SyncCrawCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scrape:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync crawl product to product';

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
        $products = CrawlProduct::where('is_sync', 0)->take(15)->get();
        foreach ($products as $crawl) {
            $product = new Product();
            $product->code = 'P' . strval(rand(0, 9999));
            $product->name = $crawl->name;
            $product->cate_id = $crawl->category;
            $product->brand_id = $crawl->brand;
            $product->price = $crawl->price;
            $product->save();
            $crawl->is_sync = 1;
            $crawl->save();
        }
    }
}
