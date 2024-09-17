<?php
namespace App\Services;

use App\Models\Product;
use App\Models\ProductSite;
use App\Models\Site;
use Illuminate\Support\Arr;

class Daraz extends CrawlService
{

    public function addProduct($uri, Site $site) {
        $this->client->request('GET', $uri);
        $crawler = $this->client->waitFor('.pdp-block__main-information');
        $name = $crawler->filter('.pdp-mod-product-badge-title')->text();
        $buyNow = $crawler->filter('#module_add_to_cart input')->attr('value');
        $thumbnail = $this->getThumbnail($crawler);
        $sku = Arr::get(json_decode($buyNow, true), 'items.0.skuId');
        return Product::createDarazProduct($uri, $sku, $name, $thumbnail, $site);
    }

    public function updateProduct(Product $product, $url, Site $site)
    {
        $product_site = ProductSite::query()->where([
            'product_id' => $product->id,
            'site_id' => $site->id,
        ])->first();
        $this->client->request('GET', $product_site->product_url ?? $url);
        $crawler = $this->client->waitFor('.pdp-block__main-information');
        $thumbnail = $this->getThumbnail($crawler);
        if($product_site) {
            $product_site->update([
                'thumbnail' => $this->getThumbnail($crawler),
            ]);
        } else {
            $product_site = ProductSite::query()->create([
                'product_id' => $product->id,
                'site_id' => $site->id,
                'product_url' => $url,
                'thumbnail' => $thumbnail,
            ]);
        }
    }

    public function fetchPrice(ProductSite $product_site)
    {
        $this->client->request('GET', $product_site->product_url);
        $crawler = $this->client->waitFor('.pdp-block__main-information', 5);
        $price = $crawler->filter('.pdp-price_type_normal')->text();
        return $price;
    }

    public function getThumbnail($crawler)
    {
        $thumbnails = $crawler->filter('div.item-gallery div.next-slick-slide')->each(function ($node, $i) {
            $typeVideo = $node->attr('type') == 'video';
            if($typeVideo) {
                return null;
            }
            return $node->filter('img')->attr('src');
        });
        $thumbnails = array_values(array_filter($thumbnails));
        if(empty($thumbnails)) {
            return null;
        }
        $uri = preg_replace('/([0-9]+)x([0-9]+)/', '750x777', $thumbnails[0]);
        if(is_url_ok($uri)) {
            return $uri;
        } else {
            return $thumbnails[0];
        }
    }
}