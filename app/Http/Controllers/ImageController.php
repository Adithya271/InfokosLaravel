<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\PaginationResource;

class ImageController extends Controller
{
    public function getImage($filename)
    {
        // Ambil gambar dari penyimpanan (misalnya direktori 'public/images')
        $imagePath = storage_path('app/public/images/' . $filename);

        if (!file_exists($imagePath)) {
            return response()->json(['error' => 'Image not found'], 404);
        }

        // Tentukan tipe mime gambar
        $mime = mime_content_type($imagePath);

        // Kirimkan gambar sebagai respons dengan tipe mime yang sesuai
        return response()->file($imagePath, [
            'Content-Type' => $mime,
            'Content-Disposition' => 'inline; filename="' . $filename . '"'
        ]);
    }


    public function uploadImage(Request $request)
    {
        // Validate the request (ensure the uploaded file is an image, etc.)
        $validator = Validator::make($request->all(), [
            'filename' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        // Store the uploaded image in the storage folder
        $imageName = time() . '.' . $request->file('filename')->getClientOriginalExtension();
        $request->file('filename')->storeAs('public/images', $imageName);

        // Save the image path to the database
        $image = Image::create(['filename' => $imageName]);

        // Return the URL of the uploaded image
        return response()->json(['path' => '/storage/images/' . $imageName, 'image_id' => $image->id, 'message' => 'save data success']);


    }


}
