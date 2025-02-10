<?php

namespace App\Livewire\Products;

use Livewire\Component;
use Livewire\Attributes\Title;
#[Title('Daftar Produk')]

class Index extends Component
{
    public function render()
    {
        return view('livewire.products.index');
    }
}
