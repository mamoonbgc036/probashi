<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class UserViewComponent extends Component
{
    public $user;

    public function mount($userId)
    {
        $this->user = User::findOrFail($userId);
    }

    public function downloadProof($type)
    {
        $file = $type === 'photo_id' ? $this->user->photo_id_proof_path : $this->user->user_proof_path;
        return response()->download(storage_path("app/public/{$file}"));
    }

    public function downloadProfilePDF()
    {
        // Assuming $this->user represents the user whose profile PDF you want to generate
        $data = ['user' => $this->user];
    
        // Render the view to HTML
        $html = View::make('livewire.admin.user-profile-pdf', $data)->render();
    
        // Instantiate Dompdf with custom settings as needed
        $options = new Options();
        $options->set('defaultFont', 'Arial'); // Optional: Set the default font
    
        $pdf = new Dompdf($options);
    
        // Load HTML content into Dompdf
        $pdf->loadHtml($html);
    
        // (Optional) Set paper size and orientation
        $pdf->setPaper('A4', 'portrait');
    
        // Render PDF (important for images and CSS)
        $pdf->render();
    
        // Generate file name for the PDF
        $fileName = 'user_profile_' . $this->user->id . '.pdf';
        
        // Path where PDF will be saved (optional)
        $savePath = storage_path('app/public/user-profiles/' . $fileName);
    
        // Ensure the directory exists; create it if it doesn't
        if (!file_exists(storage_path('app/public/user-profiles'))) {
            mkdir(storage_path('app/public/user-profiles'), 0755, true);
        }
    
        // Save the PDF file to storage (optional)
        Storage::put('public/user-profiles/' . $fileName, $pdf->output());
    
        // Download the PDF as a stream response
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, $fileName);
    }

    public function render()
    {
        return view('livewire.admin.user-view-component', [
            'user' => $this->user,
        ]);
    }
}
