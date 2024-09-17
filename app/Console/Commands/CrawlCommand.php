<?php

namespace App\Console\Commands;

use App\Models\Price;
use App\Models\ProductSite;
use Illuminate\Console\Command;
use Symfony\Component\Panther\Client;

class CrawlCommand extends Command
{
    protected $signature = 'app:crawl {--sku=}';
    protected $description = 'Crawl web';

    public function handle()
    {
        ProductSite::query()->with('site', 'product')->chunk(100, function ($product_sites) {
            foreach($product_sites as $product_site) {
                if($this->option('sku') && $product_site->product->sku != $this->option('sku')) {
                    continue;
                }
                try {
                    $price = $product_site->site->fetchPrice($product_site);
                    $currency = explode(' ', $price)[0];
                    $amount = explode(' ', $price)[1];
                    Price::query()->create([
                        'product_site_id' => $product_site->id,
                        'currency' => $currency,
                        'price' => preg_replace('/[^0-9.]/', '', $amount),
                        'checked_at' => now(),
                    ]);
                    $this->info("SKU: {$product_site->product->sku} - ✔");
                } catch (\Throwable $th) {
                    //throw $th;
                }
            }
        });
    }
}
