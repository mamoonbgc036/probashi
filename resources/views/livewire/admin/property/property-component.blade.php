<!-- resources/views/livewire/admin/property/property-component.blade.php -->
<div>
    @if($isOpen)
        @include('livewire.admin.property.create-property')
    @endif

    <div class="d-flex justify-content-end mb-3">
        <button wire:click="create" class="btn btn-lg btn-primary next-button">Create Services</button>
    </div>

    <table class="table table-hover bg-white border rounded-lg">
        <thead class="thead-sm thead-black">
            <tr>
                <th scope="col" class="border-top-0 px-6 pt-5 pb-4">Name</th>
                <th scope="col" class="border-top-0 px-6 pt-5 pb-4">Country</th>
                <th scope="col" class="border-top-0 px-6 pt-5 pb-4">City</th>
                <th scope="col" class="border-top-0 px-6 pt-5 pb-4">Area Property Type</th>
                <th scope="col" class="border-top-0 px-6 pt-5 pb-4">Photo</th>
                <th scope="col" class="border-top-0 px-6 pt-5 pb-4">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($properties as $property)
                <tr class="shadow-hover-xs-2 bg-hover-white">
                    <td class="align-middle">{{ $property->name }}</td>
                    <td class="align-middle">{{ $property->country->name }}</td>
                    <td class="align-middle">{{ $property->city->name }}</td>
                    <td class="align-middle">{{ $property->propertyType->type }}</td>
                    <td class="align-middle">
                        @if ($property->photo)
                            <img src="{{ asset('storage/' . $property->photo) }}" alt="Property Photo" class="w-24 h-24 rounded-full">
                        @else
                            <img src="default_image_path" alt="Default Photo" class="w-24 h-24 rounded-full">
                        @endif
                    </td>
                    <td class="align-middle">
                        <button wire:click="edit({{ $property->id }})" class="btn btn-lg btn-primary next-button mb-3">Edit</button>
                        <button wire:click="delete({{ $property->id }})" class="btn btn-lg btn-primary next-button mb-3">Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
