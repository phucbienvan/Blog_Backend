<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

abstract class BaseService
{
    public function createImage($thumbnailMessage = null, $imageRequest, $path = null)
    {
        if (isset($imageRequest)) {
            if ($thumbnailMessage != $imageRequest) {
                $fileName = Str::uuid() . '.' . $imageRequest->getClientOriginalExtension();
                $fullPath = $path . '/' . time() . $fileName;
                Storage::disk()->put($fullPath, file_get_contents($imageRequest));

                return $fullPath;
            }
        }

        return $thumbnailMessage;
    }
}
