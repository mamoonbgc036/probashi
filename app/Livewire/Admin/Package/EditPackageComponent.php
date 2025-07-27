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
use App\Models\Room;
use App\Models\RoomPrice;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditPackageComponent extends Component
{
    use WithFileUploads;

    public $packageId;
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

    public function mount($packageId)
    {
        $this->packageId = $packageId;
        $package = Package::with('rooms.prices', 'maintains', 'amenities', 'photos')->findOrFail($packageId);

        $this->country_id = $package->country_id;
        $this->city_id = $package->city_id;
        $this->area_id = $package->area_id;
        $this->property_id = $package->property_id;
        $this->name = $package->name;
        $this->address = $package->address;
        $this->map_link = $package->map_link;
        $this->number_of_kitchens = $package->number_of_kitchens;
        $this->number_of_rooms = $package->number_of_rooms;
        $this->common_bathrooms = $package->common_bathrooms;
        $this->seating = $package->seating;
        $this->details = $package->details;
        $this->video_link = $package->video_link;

        // Load and set relationships
        $this->loadRelatedData($package);
    }

    protected function loadRelatedData($package)
    {
        $this->countries = Country::all();
        $this->properties = Property::all();
        $this->maintains = Maintain::all();
        $this->amenities = Amenity::all();

        $this->rooms = $package->rooms->map(function($room) {
            return [
                'id' => $room->id,
                'name' => $room->name,
                'number_of_beds' => $room->number_of_beds,
                'number_of_bathrooms' => $room->number_of_bathrooms,
                'prices' => $room->prices->toArray(),
            ];
        })->toArray();

        $this->freeMaintains = $package->maintains->where('pivot.is_paid', false)->pluck('id')->toArray();
        $this->freeAmenities = $package->amenities->where('pivot.is_paid', false)->pluck('id')->toArray();

        $this->paidMaintains = $package->maintains->where('pivot.is_paid', true)->map(function ($maintain) {
            return [
                'maintain_id' => $maintain->id,
                'price' => $maintain->pivot->price,
            ];
        })->toArray();

        $this->paidAmenities = $package->amenities->where('pivot.is_paid', true)->map(function ($amenity) {
            return [
                'amenity_id' => $amenity->id,
                'price' => $amenity->pivot->price,
            ];
        })->toArray();

        $entireProperty = $package->entireProperty;
        if ($entireProperty) {
            $this->selection = 'entire';
            $this->entireProperty['prices'] = $entireProperty->prices->toArray();
        } else {
            $this->selection = 'room';
        }
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
            'id' => null,
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
        $roomId = $this->rooms[$index]['id'];
        if ($roomId) {
            Room::find($roomId)->delete();
        }
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
        $this->rooms[$roomIndex]['prices'] = array_values($this->rooms[$roomIndex]['prices']);
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

    public function update()
    {
        $this->validate();

        $package = Package::find($this->packageId);

        $package->update([
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
        ]);

        // Update or create the associated relationships
        $this->updateOrCreateRelatedData($package);

        session()->flash('message', 'Package updated successfully.');

        return redirect()->route('admin.packages');
    }

    protected function updateOrCreateRelatedData($package)
    {
        if ($this->selection == 'entire') {
            // Check if entire property exists and update or create
            $entireProperty = $package->entireProperty ?? new EntireProperty(['package_id' => $package->id]);
            
            // Only set user_id when creating a new record
            if (!$entireProperty->exists) {
                $entireProperty->user_id = Auth::id();
            }
            
            $entireProperty->save();
    
            // Update RoomPrice records for the entire property
            RoomPrice::where('entire_property_id', $entireProperty->id)->delete();
    
            foreach ($this->entireProperty['prices'] as $priceData) {
                $entireProperty->prices()->create([
                    'type' => $priceData['type'],
                    'fixed_price' => $priceData['fixed_price'],
                    'discount_price' => $priceData['discount_price'],
                    'booking_price' => $priceData['booking_price'],
                ]);
            }
        } else {
            // Handle room-related data
            $package->entireProperty()->delete();
            $this->updateRooms($package);
        }
    
        // Sync maintains and amenities
        $package->maintains()->sync($this->getMaintainsSyncData());
        $package->amenities()->sync($this->getAmenitiesSyncData());
    }
    


    protected function updateRooms($package)
    {
        foreach ($this->rooms as $roomData) {
            $room = $package->rooms()->updateOrCreate(['id' => $roomData['id']], [
                'name' => $roomData['name'],
                'number_of_beds' => $roomData['number_of_beds'],
                'number_of_bathrooms' => $roomData['number_of_bathrooms'],
            ]);

            // Delete existing prices for the room
            RoomPrice::where('room_id', $room->id)->delete();

            foreach ($roomData['prices'] as $priceData) {
                $room->prices()->create([
                    'type' => $priceData['type'],
                    'fixed_price' => $priceData['fixed_price'],
                    'discount_price' => $priceData['discount_price'],
                    'booking_price' => $priceData['booking_price'],
                    'user_id' => Auth::id(), // Set user_id when creating new prices
                ]);
            }
        }
    }


    protected function getMaintainsSyncData()
    {
        $syncData = [];

        foreach ($this->freeMaintains as $maintainId) {
            $syncData[$maintainId] = ['is_paid' => false, 'price' => null];
        }

        foreach ($this->paidMaintains as $paidMaintain) {
            $syncData[$paidMaintain['maintain_id']] = ['is_paid' => true, 'price' => $paidMaintain['price']];
        }

        return $syncData;
    }

    protected function getAmenitiesSyncData()
    {
        $syncData = [];

        foreach ($this->freeAmenities as $amenityId) {
            $syncData[$amenityId] = ['is_paid' => false, 'price' => null];
        }

        foreach ($this->paidAmenities as $paidAmenity) {
            $syncData[$paidAmenity['amenity_id']] = ['is_paid' => true, 'price' => $paidAmenity['price']];
        }

        return $syncData;
    }

    public function render()
    {
        return view('livewire.admin.package.edit-package-component');
    }
}
