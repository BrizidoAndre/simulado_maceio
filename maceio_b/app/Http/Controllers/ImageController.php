<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function index()
    {
        $images = Image::all();
        return view('gallery.index', compact('images'));
    }

    public function create()
    {
        return view('gallery.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category_id' => ['nullable', 'exists:categories,id'],
        ]);
        $file = $request->file('image');
        $url = $file->move('assets/posts_images');
        if (Image::where('metadata_hash', md5($file->getClientOriginalName()))->exists()) {
            return back()->with('danger', 'image already exists');
        }
        unset($data['image']);
        Image::create([
            ...$data,
            'image_path' => $url->getPathname(),
            'metadata_hash' => md5($file->getClientOriginalName()),
        ]);
        return redirect()->route('gallery.index');
    }

    public function destroy($image)
    {
        $image = Image::findOrFail($image);
        if ($image->post) {
            return back()->with('danger', 'This image is related to another post. To delete this image, delete the corresponding post');
        }
        unlink($image->image_path);
        $image->delete();
        return redirect()->route('gallery.index');
    }
}
