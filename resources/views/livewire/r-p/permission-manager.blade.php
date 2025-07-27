<div class="rounded-2xl p-12 card">
    @if ($editingPermissionId)
        <!-- Update Permission Form -->
        <form wire:submit.prevent="updatePermission({{ $editingPermissionId }})" class="mb-4">
    @else
        <!-- Create Permission Form -->
        <form wire:submit.prevent="createPermission" class="mb-4">
    @endif
    <div class="form-group">
        <input type="text" wire:model.defer="name" class="form-control form-control-lg border-0 mb-4" placeholder="Enter Permission Name">
        @error('name') <span class="text-red-500">{{ $message }}</span> @enderror
    </div>
        <button type="submit" class="btn btn-lg btn-primary next-button mb-3">
            @if ($editingPermissionId)
                Update Permission
            @else
                Create Permission
            @endif
        </button>
    </form>

    <!-- Assign Permission to Role -->
    <form wire:submit.prevent="assignPermission" class="mb-4">
        <div wire:ignore class="form-group">
            <!-- Permission Selection -->
            <select wire:model="selectedPermissionId" multiple class="form-control border-0 shadow-none form-control-lg selectpicker" data-style="btn-lg py-2 h-52">
                <option value="">Select Permission</option>
                @foreach($permissions as $permission)
                    <option value="{{ $permission->id }}">{{ $permission->name }}</option>
                @endforeach
            </select>

            <!-- Role Selection -->
            <select wire:model="selectedRole" class="form-control border-0 shadow-none form-control-lg selectpicker" data-style="btn-lg py-2 h-52">
                <option value="">Select Role</option>
                @foreach($roles as $role)
                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-lg btn-primary next-button mb-3">Assign Permission</button>
    </form>

    <!-- Permission List -->
    <table class="min-w-full divide-y divide-gray-200">
        <thead>
            <tr>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Name</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Associated Role</th>
                <th class="px-6 py-3 bg-gray-50">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($permissions as $permission)
                <tr>
                    <td class="px-6 py-4 whitespace-no-wrap">{{ $permission->name }}</td>
                    <td class="px-6 py-4 whitespace-no-wrap">
                        @if ($permission->roles->isNotEmpty())
                            {{ $permission->roles->implode('name', ', ') }}
                        @else
                            None
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-no-wrap">
                        <button wire:click="editPermission({{ $permission->id }})" class="btn btn-lg btn-primary next-button mb-3">Edit</button>
                        <button wire:click="deletePermission({{ $permission->id }})" class="btn btn-lg btn-primary next-button mb-3">Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
