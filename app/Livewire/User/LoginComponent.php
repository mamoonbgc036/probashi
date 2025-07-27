<?php

namespace App\Livewire\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class LoginComponent extends Component
{
    public $phone_number;
    public $password;
    public $remember;

    public function loginn()
    {
        $credentials = $this->validate([
            'phone_number' => 'required|string',
            'password' => 'required|string',
        ]);

        // You may need to adjust this to use phone_number as login field
        if (Auth::attempt(['phone_number' => $this->phone_number, 'password' => $this->password], $this->remember)) {
            session()->flash('message', 'Login successful.');
            return redirect()->intended('/');
        } else {
            throw ValidationException::withMessages([
                'phone_number' => __('auth.failed'),
            ]);
        }
    }

    public function render()
    {
        return view('livewire.user.login-component');
    }
}
