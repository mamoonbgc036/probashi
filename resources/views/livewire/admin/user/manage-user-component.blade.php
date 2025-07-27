<div>
    <!-- Button to open modal -->

    <button wire:click="openModal" class="btn btn-primary mb-4">Create User</button>

    <!-- Modal for creating user -->
    @if($isOpen)
    <div class="overlay" wire:click="closeModal"></div>
    <div class="modal fixed inset-0 flex items-center justify-center z-50" tabindex="-1" role="dialog" style="display:block;">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create User</h5>
                </div>
                <div class="modal-body">
                    <!-- User creation form -->
                    <form wire:submit.prevent="createUser">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control form-control-lg border-0" id="name" wire:model.defer="name">
                            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control form-control-lg border-0" id="email" wire:model.defer="email">
                            @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control form-control-lg border-0" id="password" wire:model.defer="password">
                            @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="role">Role</label>
                            <select class="form-control form-control-lg border-0" id="role" wire:model="role">
                                <option value="">Select Role</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->name}}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                            @error('role') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex justify-end">
                            <button type="button" wire:click="closeModal" class="btn btn-lg btn-secondary next-button mb-3 mr-2">Cancel</button>
                            <button type="submit" class="btn btn-lg btn-primary next-button mb-3">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- User list -->
    <table class="table table-hover bg-white border rounded-lg">
        <thead class="thead-sm thead-black">
            <tr>
                <th scope="col" class="border-top-0 px-6 pt-5 pb-4">Name</th>
                <th scope="col" class="border-top-0 px-6 pt-5 pb-4">Email</th>
                <th scope="col" class="border-top-0 px-6 pt-5 pb-4">Role</th>
                <th scope="col" class="border-top-0 px-6 pt-5 pb-4">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr class="shadow-hover-xs-2 bg-hover-white">
                    <td class="align-middle">{{ $user->name }}</td>
                    <td class="align-middle">{{ $user->email }}</td>
                    <td class="border border-gray-200 px-4 py-2">
                        @foreach($user->roles as $role)
                            {{ $role->name }}@if(!$loop->last),@endif
                        @endforeach
                    </td>
                    <td class="align-middle">
                        <a href="{{ route('admin.users.view', ['userId' => $user->id]) }}" class="btn btn-lg btn-secondary next-button mb-3">View User</a>
                        <button class="btn btn-lg btn-primary next-button mb-3 mr-2" wire:click="deleteUser({{ $user->id }})" onclick="return confirm('Are you sure you want to delete this user?')">Delete</button>
                    </td>                    
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
