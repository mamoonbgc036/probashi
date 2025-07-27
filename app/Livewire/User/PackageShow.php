<?php

namespace App\Livewire\User;

use App\Models\Amenity;
use App\Models\Booking;
use App\Models\Maintain;
use App\Models\Package;
use App\Models\Room;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class PackageShow extends Component
{
    public $package;
    public $packageId;
    public $views;
    public $fromDate;
    public $toDate;
    public $name;
    public $email;
    public $phone;
    public $password;
    public $viewMore = false;
    public $showAuthWarning;
    public $currentPhotoIndex = 0;
    public $showTermsModal = false;
    public $selectedMaintains = [];
    public $selectedAmenities = [];
    public $selectedRooms = [];
    public $availableRooms = [];




    public function mount($id)
    {
        $this->packageId = $id;
        $this->fetchPackage();
        $this->incrementViews();

        if (Auth::check()) {
            $this->name = Auth::user()->name;
            $this->email = Auth::user()->email;
            $this->phone = Auth::user()->phone;
        }
        $this->currentPhotoIndex = 0;
    }

    public function toggleModal()
    {
        $this->showTermsModal = !$this->showTermsModal;
    }


    public function previousPhoto()
    {
        if ($this->currentPhotoIndex > 0) {
            $this->currentPhotoIndex--;
        }
    }

    public function nextPhoto()
    {
        if ($this->currentPhotoIndex < $this->package->photos->count() - 1) {
            $this->currentPhotoIndex++;
        }
    }

    public function fetchPackage()
    {

        $this->package = Package::with([
            'country',
            'city',
            'area',
            'property',
            'maintains',
            'amenities',
            'entireProperty.prices',
            'rooms.roomPrices',
            'photos',
        ])->findOrFail($this->packageId);
    }

    public function incrementViews()
    {
        $sessionKey = 'package_' . $this->packageId . '_views';

        if (!Session::has($sessionKey)) {
            Session::put($sessionKey, 0);
        }

        $this->views = Session::increment($sessionKey);
    }

    public function getRoomPricesData()
    {
        $roomPricesData = [];
        foreach ($this->package->rooms as $room) {
            $roomPricesData[$room->id] = $room->roomPrices->groupBy('type')->toArray();
        }
        return $roomPricesData;
    }

    public function getSelectedMaintainsData()
    {
        $selectedMaintainsData = [];
        foreach ($this->selectedMaintains as $maintainId => $price) {
            $maintain = $this->package->maintains()->wherePivot('is_paid', true)->find($maintainId);
            if ($maintain) {
                $selectedMaintainsData[] = [
                    'id' => $maintain->id,
                    'name' => $maintain->name,
                    'price' => $maintain->pivot->price,
                ];
            }
        }
        return $selectedMaintainsData;
    }

    public function getSelectedAmenitiesData()
    {
        $selectedAmenitiesData = [];
        foreach ($this->selectedAmenities as $amenityId => $price) {
            $amenity = $this->package->amenities()->wherePivot('is_paid', true)->find($amenityId);
            if ($amenity) {
                $selectedAmenitiesData[] = [
                    'id' => $amenity->id,
                    'name' => $amenity->name,
                    'price' => $amenity->pivot->price,
                ];
            }
        }
        return $selectedAmenitiesData;
    }


    public function fetchAvailableRooms()
    {
        if (!$this->fromDate || !$this->toDate) {
            return [];
        }

        // Fetch all booked room IDs within the date range
        $bookedRoomIds = Booking::where(function ($query) {
            $query->whereBetween('from_date', [$this->fromDate, $this->toDate])
                ->orWhereBetween('to_date', [$this->fromDate, $this->toDate])
                ->orWhere(function ($query) {
                    $query->where('from_date', '<=', $this->fromDate)
                            ->where('to_date', '>=', $this->toDate);
                });
        })->pluck('room_ids')->flatMap(function ($roomIdsJson) {
            return json_decode($roomIdsJson, true) ?: [];
        })->toArray();

        // Fetch all rooms in the package
        $allRooms = Room::where('package_id', $this->packageId)->get();

        // Filter out booked rooms
        $availableRooms = $allRooms->filter(function($room) use ($bookedRoomIds) {
            return !in_array($room->id, $bookedRoomIds);
        });

        return $availableRooms;
    }


    public function updated($propertyName)
    {
        if (in_array($propertyName, ['fromDate', 'toDate'])) {
            $this->availableRooms = $this->fetchAvailableRooms();
        }
    }


    public function submit()
    {
        $this->validate([
            'fromDate' => 'required|date',
            'toDate' => 'required|date|after:fromDate',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:15',
            'password' => 'nullable|string|min:8'
        ]);

        // Check if the email already exists
        $existingUser = User::where('email', $this->email)->first();

        if ($existingUser && !Auth::check()) {
            $this->addError('email', 'This email is already in use. Please sign in or use a different email.');
            return;
        }

        if (!Auth::check()) {
            // Check if password is provided for registration
            if (!$this->password) {
                $this->addError('password', 'Password is required for registration if not logged in.');
                return;
            }

            // Register the user
            $user = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
                'password' => Hash::make($this->password),
            ]);

            $user->assignRole('User');
            // Log in the user
            Auth::login($user);
        }


        session()->put('checkout_data', [
            'packageId' => $this->packageId,
            'fromDate' => $this->fromDate,
            'toDate' => $this->toDate,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'roomPrices' => $this->getRoomPricesData(),
            'selectedMaintains' => $this->getSelectedMaintainsData(),
            'selectedAmenities' => $this->getSelectedAmenitiesData(),
            'selectedRooms' => $this->selectedRooms,
        ]);

        return redirect()->route('checkout');

    }

    public function getFirstAvailablePrice($prices)
    {
        $types = ['Day', 'Week', 'Month'];
        foreach ($types as $type) {
            foreach ($prices as $price) {
                if ($price->type === $type) {
                    return [
                        'price' => $price,
                        'type' => $type
                    ];
                }
            }
        }
        return null;
    }

    public function getPriceIndicator($type)
    {
        switch ($type) {
            case 'Day':
                return '(P/N by Room)';
            case 'Week':
                return '(P/W by Room)';
            case 'Month':
                return '(P/M by Room)';
            default:
                return '';
        }
    }


    public function showAuthMessage($field)
    {
        if (!Auth::check()) {
            $this->showAuthWarning = $field;
        }
    }

    public function render()
    {
        $similarPackages =  Package::with(['country', 'city', 'area', 'rooms', 'photos'])
        ->take(4)
        ->get();

        $this->package->load('user');

        return view('livewire.user.package-show', [
            'package' => $this->package,
            'views' => $this->views,
            'similarPackages' => $similarPackages,
        ])->layout('layouts.guest');
    }

    public function toggleViewMore()
    {
        $this->viewMore = !$this->viewMore; // Toggle $viewMore variable
    }

}
