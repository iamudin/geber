<?php

namespace App\Livewire\Admin\Banners;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
#[Layout('layouts.admin')]
#[Title('Banner')]
class Index extends Component
{
    public function render()
    {
        return view('livewire.admin.banners.index');
    }
}
