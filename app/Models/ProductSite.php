<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSite extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function site()
    {
        return $this->belongsTo(Site::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function prices()
    {
        return $this->hasMany(Price::class);
    }
}
