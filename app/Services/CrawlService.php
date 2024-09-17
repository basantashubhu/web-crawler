<?php
namespace App\Services;

use App\Models\Site;
use App\Models\Product;
use App\Models\ProductSite;
use Symfony\Component\Panther\Client;

abstract class CrawlService
{
    protected $uri;
    protected $client;

    public function __construct() {
        $this->client = Client::createChromeClient();
    }

    abstract function addProduct($uri, Site $site);
    abstract function updateProduct(Product $product, $url, Site $site);
    abstract function fetchPrice(ProductSite $product_site);
}