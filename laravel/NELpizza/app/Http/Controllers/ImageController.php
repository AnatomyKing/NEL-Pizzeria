<?php

namespace App\Http\Controllers;

use App\Models\Pizza;
use Illuminate\Http\Response;

class ImageController extends Controller
{
    public function show($id)
    {
        $pizza = Pizza::findOrFail($id);

        if (!$pizza->image) {
            abort(404, 'Image not found.');
        }

        return response($pizza->image, 200)
            ->header('Content-Type', 'image/jpeg'); // Adjust if your image type differs
    }
}
