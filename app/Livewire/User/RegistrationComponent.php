<?php

namespace App\Livewire\User;

use App\Models\Area;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class RegistrationComponent extends Component
{
    public $name;
    public $email;
    public $password;
    public $agreeUserTerms;
    public $agreePartnerTerms;
    public $country;
    public $city;
    public $looking_for;
    public $phone_number;
    public $phone_number_login;
    public $remember;
    public $areas;
    public $role = "User";


    public function mount()
    {
        $this->areas = Area::all();
    }
    public function register()
    {
        // Validation
        $this->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|string|in:User,Partner',
            'country' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'looking_for' => 'nullable|exists:areas,id',
        ]);

        // Create a new user
        $user = User::create([
            'name' => $this->name,
            'phone_number' => $this->phone_number,
            'password' => Hash::make($this->password),
            'country' => $this->country,
            'city' => $this->city,
            'looking_for' => $this->looking_for,
        ]);

        // Assign the selected role
        $user->assignRole($this->role);

        // Log the user in
        Auth::login($user);

        // Optionally, you can redirect the user to another page after registration
        sweetalert()->success('Registration successful.');
        return redirect(request()->header('Referer'));
    }
    
    public function render()
    {
        return view('livewire.user.registration-component');
    }
}
