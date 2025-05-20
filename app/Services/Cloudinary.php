<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Log;

class Cloudinary
{
    public function upload($file)
    {
        try {
            $uploadedImage = cloudinary()->uploadApi()->upload($file, [
                'folder' => 'borderlesshr-job-board'
            ]);

            return $uploadedImage['secure_url'];
        } catch (Exception $e) {
            Log::error('error uploading image via cloudinary', [$e]);
            return null;
        }
    }
}
