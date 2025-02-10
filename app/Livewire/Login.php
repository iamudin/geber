<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
#[Layout('layouts.auth')]
#[Title('Masuk - Geber.id')]

class Login extends Component
{
    #[Rule(['required', 'email'])]
    public string $email = '';

    #[Rule(['required'])]
    public string $password = '';

    public function login()
    {
        if (Auth::attempt($this->validate())) {
            if(Auth::user()->isAdmin()){
                return to_route('admin.dashboard');
            }elseif(Auth::user()->isMember()){
                return to_route('home');
            }


        }
        throw ValidationException::withMessages([
            'email' => 'Email credentials not match',
        ]);
    }
    public function render()
    {
        return view('livewire.login');
    }
}
