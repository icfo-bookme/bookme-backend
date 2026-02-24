<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Image;

class ImageManagerController extends Controller
{
   
public function index()
{
    $images = Image::all(); // fetch all images from DB
    return view('image-manager', compact('images'));
}


    public function upload(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:2048'
        ]);

        $file = $request->file('image');
        $fileName = $file->getClientOriginalName();
        $file->move(public_path('uploads'), $fileName);

        Image::create(['file_name' => $fileName]);

        return redirect()->back()->with('success', 'Image uploaded successfully.');
    }

    public function delete($id)
    {
        $image = Image::findOrFail($id);
        $filePath = public_path('uploads/' . $image->file_name);

        if (file_exists($filePath)) {
            unlink($filePath);
        }

        $image->delete();

        return redirect()->back()->with('warning', 'Image deleted.');
    }
}
