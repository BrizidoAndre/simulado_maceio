<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();
        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required',],
            'category_id' => ['exists:categories,id',],
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048',],
            'content' => ['required',],
            'highlight' => ['required', 'boolean'],
        ]);
        $file = $request->file('image');
        if (Image::where('metadata_hash', md5($file->getClientOriginalName()))->exists()) {
            return back()->with('danger', 'image already exists');
        }
        $url = $file->move('assets/posts_images');
        unset($data['image']);
        $post = Post::create($data);
        $post->image()->create([
            'image_path' => $url->getPathname(),
            'metadata_hash' => md5($file->getClientOriginalName()),
        ]);
        return redirect()->route('post.index');
    }

    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $data = $request->validate([
            'title' => ['required',],
            'category_id' => ['exists:categories,id',],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048',],
            'content' => ['required',],
            'highlight' => ['required', 'boolean'],
        ]);
        $url = $post->image->image_path;
        $hash = $post->image->metadata_hash;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            if (Image::where('metadata_hash', md5($file->getClientOriginalName()))->exists()) {
                return back()->with('danger', 'image already exists');
            }
            $url = $file->move('assets/posts_images');
            unset($data['image']);
            $url = $url->getPathname();
            $hash = md5($file->getClientOriginalName());
        }
        $post->update($data);
        $post->image()->update([
            'image_path' => $url,
            'metadata_hash' => $hash,
        ]);
        return redirect()->route('post.index');
    }

    public function destroy(Post $post)
    {
        unlink($post->image->image_path);
        $post->image()->delete();
        $post->delete();
        return redirect()->route('post.index');
    }

    public function toggle(Post $post)
    {
        $status = $post->status === 'Draft' ? 'Published' : 'Draft';
        $post->update(['status' => $status]);
        return redirect()->route('post.index');
    }

}
