<?php

namespace App\Http\Controllers;
 use Illuminate\Http\Request;
use App\Models\Image;

class ImageController extends Controller
{
    // 1️⃣ List all images
   public function index()
{
    $images = Image::all()->map(function($img){
        $img->image_url = $img->image_url ?? asset('images/'.$img->image);
        return $img;
    });
    return response()->json($images);
}
   public function show($id)
{
    $images = Image::find($id);
   return response()->json($images);
}


    // 2️⃣ Add new image
    public function addImage(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpg,png,jpeg,gif|max:2048'
        ]);

        $filename = time() . '.' . $request->file('image')->extension();
        $request->file('image')->move(public_path('images'), $filename);

        $image = new Image();
        $image->title = $request->title;
        $image->image = $filename;
        $image->image_url = asset('images/' . $filename);
        $image->save();

        return response()->json([
            'message' => 'Image uploaded successfully!',
            'data' => $image
        ]);
    }

    // 3️⃣ Update image by ID
    public function updateImage(Request $request, $id)
    {
        $image = Image::find($id);
        if (!$image) {
            return response()->json(['error' => 'Image not found'], 404);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048'
        ]);

        $image->title = $request->title;

        if ($request->hasFile('image')) {
            $oldPath = public_path('images/' . $image->image);
            if ($image->image && file_exists($oldPath)) {
                unlink($oldPath); // delete old file
            }

            $filename = time() . '.' . $request->file('image')->extension();
            $request->file('image')->move(public_path('images'), $filename);
            $image->image = $filename;
            $image->image_url = asset('images/' . $filename);
        } else {
            $image->image_url = $image->image_url ?? asset('images/' . $image->image);
        }

        $image->save();

        return response()->json([
            'message' => 'Image updated successfully!',
            'data' => $image
        ]);
    }

    // 4️⃣ Delete image by ID
    public function deleteImage($id)
    {
        $image = Image::find($id);
        if (!$image) {
            return response()->json(['error' => 'Image not found'], 404);
        }

        // Delete file from public/images
        $path = public_path('images/' . $image->image);
        if ($image->image && file_exists($path)) {
            unlink($path);
        }

        // Delete row from database
        $image->delete();

        return response()->json([
            'message' => 'Image deleted successfully!'
        ]);
    }
}
