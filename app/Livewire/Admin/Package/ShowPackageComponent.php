<?php

namespace App\Livewire\Admin\Package;

use App\Models\Package;
use Livewire\Component;

class ShowPackageComponent extends Component
{
    public $package;

    public function mount($packageId)
    {
        $this->package = Package::with(['rooms', 'maintains', 'amenities', 'photos'])->findOrFail($packageId);
    }

    public function render()
    {
        return view('livewire.admin.package.show-package-component');
    }
}
