<?php

namespace App\Scraper;

use App\Models\CrawlProduct;
use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;

class Smartphone
{
    protected $brands = [
         1 => 'apple-iphone',
        2 => 'samsung' ,
    ];
    protected $crawl_url = 'https://www.thegioididong.com/dtdd-';

    public function handle()
    {
        foreach ($this->brands as $brandId => $brandName) {
            $this->scrape($brandId, $brandName);
        }
    }

    public function scrape($brandId, $brandName)
    {
        $url = $this->crawl_url . $brandName . '#i:10';
        $client = new Client();
        $crawler = $client->request('GET', $url);
        $crawler->filter('ul.homeproduct li.item')->each(
            function (Crawler $node) use ($brandId) {
                try {
                    $name = $node->filter('h3')->text();
                    $price = $node->filter('.price strong')->text();
                    $price = preg_replace('/\D/', '', $price); // parse string to int
                    $cate = 2;
                    $crawler_product = new CrawlProduct();
                    $crawler_product->name = $name;
                    $crawler_product->brand = $brandId;
                    $crawler_product->category = $cate;
                    $crawler_product->price = $price;
                    $crawler_product->save();
                } catch (\RuntimeException $ex2) {
                } catch (\InvalidArgumentException $ex3) {
                }
            }
        );
    }
}
