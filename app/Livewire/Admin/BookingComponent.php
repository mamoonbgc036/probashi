<?php

namespace App\Livewire\Admin;

use App\Models\Booking;
use App\Models\Package;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class BookingComponent extends Component
{
    public $bookings;

    public function mount()
    {
        $user = Auth::user();

        if ($user->hasRole('Super Admin')) {
            // Super Admin can see all bookings
            $this->bookings = Booking::with(['user', 'package'])->get();
        } else {
            // Users can see only the bookings related to the packages they created
            $packageIds = Package::where('user_id', $user->id)->pluck('id');
            $this->bookings = Booking::with(['user', 'package'])
                ->whereIn('package_id', $packageIds)
                ->get();
        }
    }
    public function render()
    {
        return view('livewire.admin.booking-component');
    }
}
