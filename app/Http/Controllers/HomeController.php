<?php

namespace App\Http\Controllers;

use App\Models\ProductSite;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function show(ProductSite $product_site)
    {
        $product_site->load('prices');
        foreach($product_site->prices as $price) {
            $price->date = substr($price->checked_at->format('M d, D'), 0, -1);
        }
        return view('show', compact('product_site'));
    }
}
