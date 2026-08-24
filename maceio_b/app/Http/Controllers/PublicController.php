<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Image;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    /**
     * render the index default page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
     */
    public function index()
    {
        $posts = Post
            ::where('highlight', true)
            ->orderby('created_at', 'desc')
            ->limit(3)->get();
        if (count($posts) < 3) {
            $posts = Post
                ::orderby('created_at', 'desc')
                ->limit(3)->get();
        }
        return view('public.welcome', compact('posts'));
    }

    public function contact(Request $request)
    {
        $data = $request->validate([
            'name' => ['required',],
            'email' => ['required', 'email'],
            'message' => ['required',],
        ]);
        Contact::create($data);
        return redirect()->route('public.index')->with('success', 'Thanks for your contact!');
    }

    public function gallery()
    {
        $photos = Image::get();
        return view('public.gallery', compact('photos'));
    }

    public function posts()
    {
        $posts = Post
            ::where('status', 'Published')
            ->orderby('highlight', 'desc')
            ->get();
        return view('public.posts', compact('posts'));
    }

    public function postShow(Post $post)
    {
        return view('public.post-show', compact('post'));
    }
}
