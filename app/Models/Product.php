<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guarded = [];

    public static function createDarazProduct(string $uri, string $sku, string $name, $thumbnail, Site $site)
    {
        $product = Product::query()->firstOrNew([
            'sku' => $sku,
        ], [
            'name' => $name,
        ]);
        
        throw_if($product->exists, new \Exception('Product already exists with same sku:' . $sku));
        $product->save();

        ProductSite::query()->firstOrCreate([
            'site_id' => $site->id,
            'product_id' => $product->id,
        ], [
            'product_url' => $uri,
            'thumbnail' => $thumbnail,
        ]);

        return $product;
    }
}
