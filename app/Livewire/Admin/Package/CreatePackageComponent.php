<?php

namespace App\Livewire\Admin\Package;

use App\Models\Amenity;
use App\Models\Area;
use App\Models\City;
use App\Models\Country;
use App\Models\EntireProperty;
use App\Models\Maintain;
use App\Models\Package;
use App\Models\Property;
use App\Models\RoomPrice;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreatePackageComponent extends Component
{
    use WithFileUploads;

    public $countries;
    public $cities = [];
    public $areas = [];
    public $properties;
    public $maintains;
    public $amenities;

    public $country_id;
    public $city_id;
    public $area_id;
    public $property_id;
    public $name;
    public $address;
    public $map_link;
    public $number_of_kitchens;
    public $number_of_rooms;
    public $common_bathrooms;
    public $seating;
    public $details;
    public $video_link;
    public $rooms = [];
    public $freeMaintains = [];
    public $freeAmenities = [];
    public $paidMaintains = [];
    public $paidAmenities = [];
    public $photos = [];
    public $selection;
    public $entireProperty = [
        'prices' => [
            ['type' => '', 'fixed_price' => 0, 'discount_price' => null, 'booking_price' => 0]
        ],
    ];

    protected $rules = [
        'country_id' => 'required',
        'city_id' => 'required',
        'area_id' => 'required',
        'property_id' => 'required',
        'name' => 'required|string',
        'address' => 'required|string',
        'map_link' => 'nullable|string',
        'number_of_kitchens' => 'required|integer',
        'number_of_rooms' => 'required|integer',
        'common_bathrooms' => 'required|integer',
        'seating' => 'required|integer',
        'details' => 'nullable|string',
        'rooms.*.name' => 'string',
        'rooms.*.number_of_beds' => 'integer',
        'rooms.*.number_of_bathrooms' => 'integer',
        'rooms.*.prices.*.type' => 'in:Day,Week,Month',
        'rooms.*.prices.*.fixed_price' => 'numeric',
        'rooms.*.prices.*.discount_price' => 'nullable|numeric',
        'rooms.*.prices.*.booking_price' => 'numeric',
        'paidMaintains.*.maintain_id' => 'required|exists:maintains,id',
        'paidMaintains.*.price' => 'required|numeric',
        'paidAmenities.*.amenity_id' => 'required|exists:amenities,id',
        'paidAmenities.*.price' => 'required|numeric',
        'photos.*' => 'nullable|image',
        'entireProperty.prices.*.type' => 'in:Day,Week,Month',
        'entireProperty.prices.*.fixed_price' => 'numeric',
        'entireProperty.prices.*.discount_price' => 'nullable|numeric',
        'entireProperty.prices.*.booking_price' => 'numeric',
        'video_link' => 'nullable|url',
    ];

    public function mount()
    {
        $user = Auth::user();

        if ($user->roles->pluck('name')->contains('Super Admin')) {
            $this->countries = Country::all();
            $this->properties = Property::all();
            $this->maintains = Maintain::all();
            $this->amenities = Amenity::all();
        } else {
            $this->countries = Country::all();
            $this->properties = Property::where('user_id', $user->id)->get();
            $this->maintains = Maintain::where('user_id', $user->id)->get();
            $this->amenities = Amenity::where('user_id', $user->id)->get();
        }

        $this->addRoom();
        $this->addPaidMaintain();
        $this->addPaidAmenity();
    }


    public function updatedCountryId($value)
    {
        $this->cities = City::where('country_id', $value)->get();
    }

    public function updatedCityId($value)
    {
        $this->areas = Area::where('city_id', $value)->get();
    }

    public function addRoom()
    {
        $this->rooms[] = [
            'name' => '',
            'number_of_beds' => 0,
            'number_of_bathrooms' => 0,
            'prices' => [
                ['type' => '', 'fixed_price' => 0, 'discount_price' => null, 'booking_price' => 0]
            ]
        ];
    }

    public function removeRoom($index)
    {
        unset($this->rooms[$index]);
        $this->rooms = array_values($this->rooms);
    }

    public function addPriceOption($roomIndex)
    {
        $this->rooms[$roomIndex]['prices'][] = [
            'type' => '',
            'fixed_price' => null,
            'discount_price' => null,
            'booking_price' => null,
        ];
    }

    public function removePriceOption($roomIndex, $priceIndex)
    {
        unset($this->rooms[$roomIndex]['prices'][$priceIndex]);
        $this->rooms[$roomIndex]['prices'] = array_values($this->rooms[$roomIndex]['prices']); // Re-index array
    }


    public function addEntirePropertyPrice()
    {
        if (count($this->entireProperty['prices']) < 3) {
            $this->entireProperty['prices'][] = [
                'type' => '',
                'fixed_price' => 0,
                'discount_price' => null,
                'booking_price' => 0,
            ];
        }
    }

    public function removeEntirePropertyPrice($index)
    {
        unset($this->entireProperty['prices'][$index]);
        $this->entireProperty['prices'] = array_values($this->entireProperty['prices']);
    }


    public function addPaidMaintain()
    {
        $this->paidMaintains[] = [
            'maintain_id' => '',
            'price' => 0,
        ];
    }

    public function removePaidMaintain($index)
    {
        unset($this->paidMaintains[$index]);
        $this->paidMaintains = array_values($this->paidMaintains);
    }

    public function addPaidAmenity()
    {
        $this->paidAmenities[] = [
            'amenity_id' => '',
            'price' => 0,
        ];
    }

    public function removePaidAmenity($index)
    {
        unset($this->paidAmenities[$index]);
        $this->paidAmenities = array_values($this->paidAmenities);
    }

    public function save()
    {
        $this->validate();

        $package = Package::create([
            'country_id' => $this->country_id,
            'city_id' => $this->city_id,
            'area_id' => $this->area_id,
            'property_id' => $this->property_id,
            'name' => $this->name,
            'address' => $this->address,
            'map_link' => $this->map_link,
            'number_of_kitchens' => $this->number_of_kitchens,
            'number_of_rooms' => $this->number_of_rooms,
            'common_bathrooms' => $this->common_bathrooms,
            'seating' => $this->seating,
            'details' => $this->details,
            'video_link' => $this->video_link,
            'user_id' => Auth::id(),
        ]);

        if ($this->selection == 'entire') {
            // Save Entire Property
            $entireProperty = EntireProperty::create([
                'user_id' => Auth::id(),
                'package_id' => $package->id,
            ]);

            // Save Prices for Entire Property
            foreach ($this->entireProperty['prices'] as $priceData) {
                RoomPrice::create([
                    'entire_property_id' => $entireProperty->id,
                    'type' => $priceData['type'],
                    'fixed_price' => $priceData['fixed_price'],
                    'discount_price' => $priceData['discount_price'],
                    'booking_price' => $priceData['booking_price'],
                    'user_id' => Auth::id(),
                ]);
            }

        } else {
            // Handle room-wise saving logic
            foreach ($this->rooms as $roomData) {
                $room = $package->rooms()->create([
                    'name' => $roomData['name'],
                    'number_of_beds' => $roomData['number_of_beds'],
                    'number_of_bathrooms' => $roomData['number_of_bathrooms'],
                    'user_id' => Auth::id(),
                ]);

                foreach ($roomData['prices'] as $priceData) {
                    $room->prices()->create([
                        'type' => $priceData['type'],
                        'fixed_price' => $priceData['fixed_price'],
                        'discount_price' => $priceData['discount_price'],
                        'booking_price' => $priceData['booking_price'],
                        'user_id' => Auth::id(),
                    ]);
                }

            }

        }

        foreach ($this->freeMaintains as $maintainId) {
            $package->maintains()->attach($maintainId, ['is_paid' => false, 'user_id' => Auth::id(),]);

        }

        foreach ($this->freeAmenities as $amenityId) {
            $package->amenities()->attach($amenityId, ['is_paid' => false,'user_id' => Auth::id(),]);
        }

        foreach ($this->paidMaintains as $maintainData) {
            $package->maintains()->attach($maintainData['maintain_id'], [
                'is_paid' => true,
                'price' => $maintainData['price'],
                'user_id' => Auth::id(),
            ]);
        }

        foreach ($this->paidAmenities as $amenityData) {
            $package->amenities()->attach($amenityData['amenity_id'], [
                'is_paid' => true,
                'price' => $amenityData['price'],
                'user_id' => Auth::id(),
            ]);
        }

        foreach ($this->photos as $photo) {
            $photoPath = $photo->store('photos', 'public');
            $package->photos()->create(['url' => $photoPath, 'user_id' => Auth::id(),]);
        }

        session()->flash('message', 'Package created successfully.');

        return redirect()->route('admin.packages');
    }

    public function render()
    {
        return view('livewire.admin.package.create-package-component');
    }

}
