<?php

namespace App\Livewire;

use Livewire\Component;

class Show extends Component
{
    public $product_site;
    
    public function render()
    {
        return view('livewire.show');
    }
}
