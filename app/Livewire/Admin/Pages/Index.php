<?php

namespace App\Livewire\Admin\Pages;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
#[Layout('layouts.admin')]
#[Title('Halaman')]
class Index extends Component
{
    public function render()
    {
        return view('livewire.admin.pages.index');
    }
}
