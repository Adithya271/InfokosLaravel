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

        $imagePath = storage_path('app/public/images/' . $filename);

        if (!file_exists($imagePath)) {
            return response()->json(['error' => 'Image not found'], 404);
        }

  
        $mime = mime_content_type($imagePath);


        return response()->file($imagePath, [
            'Content-Type' => $mime,
            'Content-Disposition' => 'inline; filename="' . $filename . '"'
        ]);
    }


    public function uploadImage(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'filename' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }


        $imageName = time() . '.' . $request->file('filename')->getClientOriginalExtension();
        $request->file('filename')->storeAs('public/images', $imageName);


        $image = Image::create(['filename' => $imageName]);


        return response()->json(['path' => '/storage/images/' . $imageName, 'image_id' => $image->id, 'message' => 'save data success']);


    }


}
