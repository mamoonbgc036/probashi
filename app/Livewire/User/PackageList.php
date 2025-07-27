<?php

namespace App\Livewire\User;

use App\Models\Area;
use App\Models\City;
use App\Models\Country;
use App\Models\Package;
use Livewire\Component;
use Livewire\WithPagination;

class PackageList extends Component
{
    use WithPagination;

    public $selectedCountry;
    public $selectedCity;
    public $selectedArea;
    public $keyword;

    public $countries;
    public $cities;
    public $areas;

    public function mount()
    {
        $this->countries = Country::all();
        $this->cities = [];
        $this->areas = [];
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

    public function updatedSelectedCountry($value)
    {
        if ($value) {
            $this->cities = City::where('country_id', $value)->get();
            $this->selectedCity = null;
            $this->selectedArea = null;
        } else {
            $this->cities = [];
        }
    }

    public function updatedSelectedCity($value)
    {
        if ($value) {
            $this->areas = Area::where('city_id', $value)->get();
            $this->selectedArea = null;
        } else {
            $this->areas = [];
        }
    }

    public function search()
    {
        $this->resetPage();
    }

    public function getPackagesProperty()
    {
        return Package::with([
            'country',
            'city',
            'area',
            'rooms.prices',
            'entireProperty.prices', // Include entireProperty prices relation
            'photos'
        ])
        ->when($this->selectedCountry, function ($query) {
            return $query->where('country_id', $this->selectedCountry);
        })
        ->when($this->selectedCity, function ($query) {
            return $query->where('city_id', $this->selectedCity);
        })
        ->when($this->selectedArea, function ($query) {
            return $query->where('area_id', $this->selectedArea);
        })
        ->when($this->keyword, function ($query) {
            return $query->where('name', 'like', '%' . $this->keyword . '%');
        })
        ->paginate(10);
    }

    public function render()
    {
        $featuredPackages = Package::with(['country', 'city', 'area', 'rooms', 'photos'])
            ->take(3)
            ->get();
        return view('livewire.user.package-list', [
            'packages' => $this->packages,
            'featuredPackages' => $featuredPackages,
        ])->layout('layouts.guest');
    }

}
