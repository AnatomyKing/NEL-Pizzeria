<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Response;

class ImageController extends Controller
{
    public function show($pizzaId)
    {
        $image = Image::where('pizza_id', $pizzaId)->first();

        if (!$image) {
            abort(404, 'Image not found');
        }

        return response($image->data, 200)
            ->header('Content-Type', $image->mime_type);
    }
}