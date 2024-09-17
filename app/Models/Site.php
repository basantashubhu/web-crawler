<?php

namespace App\Models;

use App\Services\CrawlService;
use App\Services\Daraz;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    use HasFactory;

    protected $guarded = [];

    public static $service = null;

    public function resolveService() : CrawlService
    {
        if(static::$service) {
            return static::$service;
        }
        static::$service = match($this->name) {
            'www.daraz.com.np' => new Daraz(),
            default => null,
        };
        throw_unless(static::$service, new \Exception("Service unavailable for {$this->name}. Contact admin."));
        return static::$service;
    }

    public function createProductFromURL($uri)
    {
        return $this->resolveService()->addProduct($uri, $this);
    }

    public function updateProduct(Product $product, $url)
    {
        return $this->resolveService()->updateProduct($product, $url, $this);
    }

    public function fetchPrice(ProductSite $product_site)
    {
        return $this->resolveService()->fetchPrice($product_site);
    }
}
