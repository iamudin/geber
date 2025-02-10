<?php

namespace App\Livewire\Products;

use Livewire\Component;
#[\Livewire\Attributes\Title('Daftar Produk')]

class Search extends Component
{
    public function render()
    {
        return view('livewire.products.search');
    }
}
