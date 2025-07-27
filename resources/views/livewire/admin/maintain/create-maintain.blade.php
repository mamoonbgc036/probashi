<div>
    <!-- Overlay -->
    <div class="overlay" wire:click="closeModal"></div>

    <div class="fixed inset-0 flex items-center justify-center z-50">
        <div class="w-full max-w-lg p-6 bg-white rounded shadow-lg">
            <h2 class="text-2xl font-semibold mb-6">{{ $maintain_id ? 'Edit Maintain' : 'Create Maintain' }}</h2>

            <form wire:submit.prevent="store">
                <div class="mb-4">
                    <label for="maintain_type_id" class="block text-lg font-medium text-gray-700 mb-1">Type</label>
                    <select id="maintain_type_id" wire:model="maintain_type_id" class="form-control border-0 shadow-none form-control-lg mb-2">
                        <option value="">Select Type</option>
                        @foreach($maintainTypes as $type)
                            <option value="{{ $type->id }}">{{ $type->type }}</option>
                        @endforeach
                    </select>
                    @error('maintain_type_id') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label for="name" class="block text-lg font-medium text-gray-700 mb-1">Name</label>
                    <input type="text" id="name" wire:model.defer="name" class="form-control form-control-lg border-0" placeholder="Name">
                    @error('name') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label for="photo" class="block text-lg font-medium text-gray-700 mb-1">Photo</label>
                    <input type="file" id="photo" wire:model="photo" class="form-control form-control-lg border-0 shadow-none mb-2">
                    @error('photo') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>

                <div class="flex justify-end">
                    <button type="button" wire:click="closeModal" class="btn btn-lg btn-secondary next-button mb-3 mr-2">Cancel</button>
                    <button type="submit" class="btn btn-lg btn-primary next-button mb-3">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
