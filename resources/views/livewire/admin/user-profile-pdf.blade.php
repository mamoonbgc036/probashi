<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }
        .container {
            width: 100%;
            max-width: 800px; /* Adjust as necessary */
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h2 {
            font-size: 24px;
            margin-bottom: 20px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 10px;
        }
        .columns {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }
        .column {
            flex: 1 1 calc(50% - 20px); /* Adjust width and gap */
        }
        .profile-info {
            margin-bottom: 20px;
        }
        .profile-info strong {
            width: 150px;
            display: inline-block;
            font-weight: bold;
        }
        .profile-info p {
            margin: 5px 0;
        }
        .proof-files {
            margin-top: 20px;
        }
        .proof-files strong {
            display: block;
            margin-bottom: 5px;
        }
        .proof-files img {
            max-width: 100%;
            height: auto;
            margin-bottom: 10px;
        }
        .page-break {
            page-break-after: always;
        }

        .grid-container {
            display: grid;
            grid-template-columns: repeat(2, 1fr); /* Two columns */
            gap: 20px; /* Gap between grid items */
        }
        .grid-item {
            background-color: #f0f0f0;
            padding: 20px;
            border: 1px solid #ccc;
            text-align: center;
            font-size: 1.2rem;
        }
    </style>
</head>
<body>
        <h2>User Profile - {{ $user->name }}</h2>

        <div class="grid-container">
            <div class="grid-item">
                <strong>Name:</strong>
                <p>{{ $user->name }}</p>
                
                <strong>Email:</strong>
                <p>{{ $user->email }}</p>
            </div>
            <div class="grid-item">
                <strong>Phone:</strong>
                <p>{{ $user->phone }}</p>
            </div>
            <div class="grid-item">
                <strong>Photo ID Proof Type:</strong>
                <p>{{ ucfirst($user->photo_id_proof_type) }}</p>
                <div>
                    @if ($user->photo_id_proof_path)
                    @php
                        $imagePathPhotoProof = public_path('storage/' . $user->photo_id_proof_path);
                        $imageDataPhotoProof = base64_encode(file_get_contents($imagePathPhotoProof));
                        $imageSrcPhotoProof = 'data:'.mime_content_type($imagePathPhotoProof).';base64,'.$imageDataPhotoProof;
                    @endphp

                    <div class="proof-files">
                        <strong>Photo ID Proof File:</strong>
                        <img src="{{ $imageSrcPhotoProof }}" alt="Photo ID Proof">
                    </div>
                    @endif
                </div>

            </div>
            <div class="grid-item">
                <div class="profile-info">
                    <strong>User Proof Type:</strong>
                    <p>{{ ucfirst($user->user_proof_type) }}</p>
                </div>
                <div class="column">
                    @if ($user->user_proof_path)
                    @php
                        $imagePathUserProof = public_path('storage/' . $user->user_proof_path);
                        $imageDataUserProof = base64_encode(file_get_contents($imagePathUserProof));
                        $imageSrcUserProof = 'data:'.mime_content_type($imagePathUserProof).';base64,'.$imageDataUserProof;
                    @endphp
    
                    <div class="proof-files">
                        <strong>User Proof File:</strong>
                        <img src="{{ $imageSrcUserProof }}" alt="User Proof">
                    </div>
                    @endif
                </div>
            </div>
        </div>
        

</body>
</html>
