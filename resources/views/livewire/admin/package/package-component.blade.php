<div>
    @if(session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif
    <a class="btn btn-primary mb-2" href="{{route('admin.packages.create')}}">Create Package</a>
    <div class="overflow-x-auto">
        <table class="table-auto w-full">
            <thead>
                <tr>
                    <th class="px-4 py-2">#</th>
                    <th class="px-4 py-2">Country</th>
                    <th class="px-4 py-2">City</th>
                    <th class="px-4 py-2">Area</th>
                    <th class="px-4 py-2">Property</th>
                    <th class="px-4 py-2">Package Name</th>
                    <th class="px-4 py-2">Address</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($packages as $package)
                    <tr>
                        <td class="border px-4 py-2">{{ $package->id }}</td>
                        <td class="border px-4 py-2">{{ $package->country->name }}</td>
                        <td class="border px-4 py-2">{{ $package->city->name }}</td>
                        <td class="border px-4 py-2">{{ $package->area->name }}</td>
                        <td class="border px-4 py-2">{{ $package->property->name }}</td>
                        <td class="border px-4 py-2">{{ $package->name }}</td>
                        <td class="border px-4 py-2">{{ $package->address }}</td>
                        <td class="border px-4 py-2">
                            <a href="{{ route('packages.show', ['packageId' => $package->id]) }}" class="btn btn-primary"><i class="fad fa-eye"></i></a>
                            <a href="{{ route('admin.package.edit', ['packageId' => $package->id]) }}"class="btn btn-primary"><i class="fad fa-edit"></i></a>
                            <button wire:click="delete({{ $package->id }})" class="btn btn-danger"><i class="fad fa-trash"></i></button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
