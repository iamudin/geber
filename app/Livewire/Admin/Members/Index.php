<?php

namespace App\Livewire\Admin\Members;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
#[Title('Dashboard')]
#[Layout('layouts.admin')]
class Index extends Component
{
    public function render()
    {
        $member = User::with('data')->member()->paginate(20);
        return view('livewire.admin.members.index',
    [
        'members'=>$member
    ]);
    }
}
