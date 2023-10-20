<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;

class ImageUploadService
{
    // generate a unique filename, save the image, and return the path
    public function upload(UploadedFile $image)
    {
        $uniqueFileName = uniqid() . '.' . $image->getClientOriginalExtension();
        $image->storeAs('images', $uniqueFileName, 'public');

        // Get the URL of the uploaded image
        $path = asset('storage/images/' . $uniqueFileName);

        return $path;
    }

}
