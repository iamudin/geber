<?php

namespace App\Livewire\Products;

use Livewire\Component;
#[\Livewire\Attributes\Title('Detail Produk')]

class Show extends Component
{
    public function render()
    {
        return view('livewire.products.show');
    }
}
