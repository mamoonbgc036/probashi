<?php

namespace App\Livewire\Admin\User;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class ManageUserComponent extends Component
{
    public $name, $email, $password, $password_confirmation,  $role;
    public $roles, $users;
    public $isOpen = false;

    public function mount()
    {
        $this->roles = Role::all();
        $this->users = User::all();
    }

    public function createUser()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|string',
        ]);

        // dd($this->role);
        // Create the user
        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        // Assign the selected role to the user
        $user->syncRoles($this->role);

        // Reset input fields
        $this->reset(['name', 'email', 'password']);

        // Refresh user list
        $this->users = User::all();

        session()->flash('message', 'User created and role assigned successfully.');
    }


    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    public function deleteUser($userId)
    {
        // Check if the user ID is valid and the user exists
        if (!is_numeric($userId) || !User::find($userId)) {
            session()->flash('error', 'Invalid user ID or user not found.');
            return;
        }
    
        // Find and delete the user
        $user = User::find($userId);
    
        if ($user) {
            $user->delete();
            
            // Refresh user list
            $this->users = User::all();
    
            session()->flash('message', 'User deleted successfully.');
        } else {
            session()->flash('error', 'User not found.');
        }
    }
    


    public function render()
    {
        return view('livewire.admin.user.manage-user-component');
    }
}
