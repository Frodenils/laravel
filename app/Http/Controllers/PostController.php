<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();
        return view('articles',compact('posts'));
    }

    public function show($id)
    {
        $post = Post::findOrFail($id);

        return view('article',[
            'post' => $post
        ]);
    }
    public function create()
    {
        return view('form');
    }

    public function store(Request $request)
    {
        // $post = new Post();
        // $post->title = $request->title;
        // $post->content = $request->content;
        // $post->save();
        Post::create([
            'title' => $request->title,
            'content' => $request->content
        ]);
        dd('post créé');
    }
    public function contact(){
        return view('contact');
    } 
}
