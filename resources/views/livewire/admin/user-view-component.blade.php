<div>
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">User Profile - {{ $user->name }}</h5>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <strong>Name:</strong> {{ $user->name }}
                    </div>
                    <div class="mb-3">
                        <strong>Email:</strong> {{ $user->email }}
                    </div>
                    <div class="mb-3">
                        <strong>Phone:</strong> {{ $user->phone }}
                    </div>
                    <div class="mb-3">
                        <strong>Photo ID Proof Type:</strong> {{ ucfirst($user->photo_id_proof_type) }}
                    </div>
                    @if ($user->photo_id_proof_path)
                        <div class="mb-3">
                            <strong>Photo ID Proof File:</strong><br>
                            <a href="{{ asset('storage/' . $user->photo_id_proof_path) }}" target="_blank">View Photo ID Proof</a> |
                            <a href="#" wire:click.prevent="downloadProof('photo_id')">Download Photo ID Proof</a>
                        </div>
                        <div>
                            <img src="{{ asset('storage/' . $user->photo_id_proof_path) }}" alt="Photo ID Proof" style="max-width: 100%; height: auto;">
                        </div>
                    @endif
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <strong>User Proof Type:</strong> {{ ucfirst($user->user_proof_type) }}
                    </div>
                    @if ($user->user_proof_path)
                        <div class="mb-3">
                            <strong>User Proof File:</strong><br>
                            <a href="{{ asset('storage/' . $user->user_proof_path) }}" target="_blank">View User Proof</a> |
                            <a href="#" wire:click.prevent="downloadProof('user')">Download User Proof</a>
                        </div>
                        <div>
                            <img src="{{ asset('storage/' . $user->user_proof_path) }}" alt="User Proof" style="max-width: 100%; height: auto;">
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="text-center mb-4">
        <button class="btn btn-primary" wire:click.prevent="downloadProfilePDF">Download PDF</button>
    </div>
</div>
