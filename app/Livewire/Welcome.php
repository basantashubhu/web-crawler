<?php

namespace App\Livewire;

use Livewire\Component;

class Welcome extends Component
{
    public $products;

    public function mount()
    {
        $this->products = \App\Models\ProductSite::with('site', 'product')->get();
    }

    public function render()
    {
        return view('livewire.welcome');
    }
}
