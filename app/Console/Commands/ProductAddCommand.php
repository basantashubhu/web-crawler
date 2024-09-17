<?php

namespace App\Console\Commands;

use App\Models\Price;
use App\Models\Product;
use App\Models\ProductSite;
use App\Models\Site;
use Illuminate\Console\Command;

use function Laravel\Prompts\confirm;
use function Laravel\Prompts\text;

class ProductAddCommand extends Command
{
    protected $signature = 'product:add';
    protected $description = 'Add product to the app';

    public function handle()
    {
        $url = text('Product URI:');
        $parsedURL = parse_url($url);
        $site = Site::query()->firstOrCreate([
            'name' => $parsedURL['host'],
        ], [
            'url' => $parsedURL['scheme'] . '://' . $parsedURL['host'],
        ]);
        try {
            $product = $site->createProductFromURL($url);
            $this->info('Product added: ' . $product->name);
        } catch (\Throwable $th) {
            if(str_contains($th->getMessage(), 'sku:')) {
                $sku = str($th->getMessage())->after('sku:')->trim();
                if($sku && confirm('Do you want to update existing product?', default: false)) {
                    $product = Product::query()->where('sku', $sku)->first();
                    $site->updateProduct($product, $url);
                    $this->info('Product updated: ' . $product->name);
                    return;
                }
            }
            $this->error($th->getMessage());
        }
    }
}
