<?php

namespace App\Livewire\Admin;

use GrahamCampbell\ResultType\Success;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class ProfileComponent extends Component
{
    use WithFileUploads;

    public $photo_id_proof_type;
    public $photo_id_proof_file;
    public $user_proof_type;
    public $user_proof_file;
    public $photo_id_proof_temporary_url;
    public $user_proof_temporary_url;
    public $hasProofsToSave = false;

    protected $rules = [
        'photo_id_proof_type' => 'nullable|string|in:nid,passport',
        'photo_id_proof_file' => 'nullable|file|mimes:jpeg,png,pdf|max:2048',
        'user_proof_type' => 'nullable|string|in:student_id,work_id,others',
        'user_proof_file' => 'nullable|file|mimes:jpeg,png,pdf|max:2048',
    ];

    public function mount()
    {
        $user = Auth::user();
        if ($user->photo_id_proof_path && $user->user_proof_path) {
            $this->hasProofsToSave = true;
        }
    }

    public function updateProofs()
    {
        $this->validate();

        $user = Auth::user();

        if ($this->photo_id_proof_file) {
            $photoIdProofPath = $this->photo_id_proof_file->store('proofs', 'public');
            $user->photo_id_proof_type = $this->photo_id_proof_type;
            $user->photo_id_proof_path = $photoIdProofPath;
        }

        if ($this->user_proof_file) {
            $userProofPath = $this->user_proof_file->store('proofs', 'public');
            $user->user_proof_type = $this->user_proof_type;
            $user->user_proof_path = $userProofPath;
        }

        $user->save();

        $this->reset(['photo_id_proof_file', 'user_proof_file']);

        $this->hasProofsToSave = true;

        $this->dispatch('proofsUpdated');

        flash()->success('Proofs updated successfully.');
    }

    public function render()
    {
        return view('livewire.admin.profile-component', [
            'user' => Auth::user(),
        ]);
    }
}
