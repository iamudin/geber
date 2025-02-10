<?php

namespace App\Livewire\Products;

use Livewire\Component;
#[\Livewire\Attributes\Title('Kategori Produk')]

class Category extends Component
{
    public function render()
    {
        return view('livewire.products.category');
    }
}
