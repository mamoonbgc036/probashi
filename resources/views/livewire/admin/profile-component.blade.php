<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-body">
                    <h4 class="card-title">User Profile</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <strong>Name:</strong>
                                <p class="mb-0">{{ $user->name }}</p>
                            </div>
                            <div class="mb-3">
                                <strong>Email:</strong>
                                <p class="mb-0">{{ $user->email ?? 'Not Provided' }}</p>
                            </div>
                            <div class="mb-3">
                                <strong>Phone Number:</strong>
                                <p class="mb-0">{{ $user->phone_number }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <strong>Country:</strong>
                                <p class="mb-0">{{ $user->country ?? 'Not Provided' }}</p>
                            </div>
                            <div class="mb-3">
                                <strong>City:</strong>
                                <p class="mb-0">{{ $user->city ?? 'Not Provided' }}</p>
                            </div>
                            <div class="mb-3">
                                <strong>Looking For:</strong>
                                <p class="mb-0">{{ ucfirst($user?->area?->name) ?? 'Not Provided' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Upload Proofs</h5>
                    @if ($hasProofsToSave)
                        <div class="card mb-4">
                            <div class="card-body">
                                <h6 class="card-subtitle mb-2 text-muted">Current Proofs</h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <strong>Photo ID Proof Type:</strong>
                                            <p class="mb-0">{{ ucfirst($user->photo_id_proof_type) }}</p>
                                        </div>
                                        @if ($user->photo_id_proof_path)
                                            <div class="mb-3">
                                                <strong>Photo ID Proof File:</strong><br>
                                                <img src="{{ asset('storage/' . $user->photo_id_proof_path) }}" alt="Photo ID Proof" class="img-fluid rounded" style="max-width: 100%;">
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <strong>User Proof Type:</strong>
                                            <p class="mb-0">{{ ucfirst($user->user_proof_type) }}</p>
                                        </div>
                                        @if ($user->user_proof_path)
                                            <div class="mb-3">
                                                <strong>User Proof File:</strong><br>
                                                <img src="{{ asset('storage/' . $user->user_proof_path) }}" alt="User Proof" class="img-fluid rounded" style="max-width: 100%;">
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <form wire:submit.prevent="updateProofs" enctype="multipart/form-data">
                        <!-- Photo ID Proof Type -->
                        <div class="form-group">
                            <label for="photo_id_proof_type">Photo ID Proof Type</label>
                            <select wire:model="photo_id_proof_type" id="photo_id_proof_type" class="form-control">
                                <option value="">Select</option>
                                <option value="nid">NID</option>
                                <option value="passport">Passport</option>
                            </select>
                            @error('photo_id_proof_type') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
            
                        <!-- Photo ID Proof File -->
                        <div class="form-group">
                            <label for="photo_id_proof_file">Photo ID Proof File</label>
                            <input type="file" wire:model="photo_id_proof_file" id="photo_id_proof_file" class="form-control">
                            @error('photo_id_proof_file') <small class="text-danger">{{ $message }}</small> @enderror
                            <div wire:loading wire:target="photo_id_proof_file" class="text-info">Uploading...</div>
                            @if ($photo_id_proof_temporary_url)
                                <div class="mt-2">
                                    <p>Preview:</p>
                                    <img src="{{ $photo_id_proof_temporary_url }}" alt="Preview" class="img-fluid rounded" style="max-width: 200px;">
                                </div>
                            @endif
                        </div>
            
                        <!-- User Proof Type -->
                        <div class="form-group">
                            <label for="user_proof_type">User Proof Type</label>
                            <select wire:model="user_proof_type" id="user_proof_type" class="form-control">
                                <option value="">Select</option>
                                <option value="student_id">Student ID</option>
                                <option value="work_id">Work ID</option>
                                <option value="others">Others</option>
                            </select>
                            @error('user_proof_type') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
            
                        <!-- User Proof File -->
                        <div class="form-group">
                            <label for="user_proof_file">User Proof File</label>
                            <input type="file" wire:model="user_proof_file" id="user_proof_file" class="form-control">
                            @error('user_proof_file') <small class="text-danger">{{ $message }}</small> @enderror
                            <div wire:loading wire:target="user_proof_file" class="text-info">Uploading...</div>
                            @if ($user_proof_temporary_url)
                                <div class="mt-2">
                                    <p>Preview:</p>
                                    <img src="{{ $user_proof_temporary_url }}" alt="Preview" class="img-fluid rounded" style="max-width: 200px;">
                                </div>
                            @endif
                        </div>
            
                        <!-- Submit Button -->
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                @if ($hasProofsToSave)
                                    Submit Again
                                @else
                                    Save
                                @endif
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Update Profile Information -->
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Update Profile Information</h5>
                    <livewire:profile.update-profile-information-form />
                </div>
            </div>

            <!-- Update Password -->
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Update Password</h5>
                    <livewire:profile.update-password-form />
                </div>
            </div>

            {{-- <div class="card mb-4">
                <div class="card-body">
                    <livewire:profile.delete-user-form />
                </div>
            </div> --}}

        </div>
    </div>
</div>
