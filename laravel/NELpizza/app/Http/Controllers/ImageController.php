<?php

namespace App\Http\Controllers;

use App\Models\Pizza;
use Illuminate\Http\Response;

class ImageController extends Controller
{
    public function show($id)
    {
        $pizza = Pizza::findOrFail($id);

        abort_if(!$pizza->image, 404, 'Image not found.');

        return response($pizza->image)
            ->header('Content-Type', $this->getMimeType($pizza->image))
            ->header('Content-Disposition', 'inline');
    }

    private function getMimeType($imageData): string
    {
        return finfo_buffer(finfo_open(FILEINFO_MIME_TYPE), $imageData) ?: 'image/jpeg';
    }
}
