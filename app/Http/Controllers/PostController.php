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
        //$post = Post::findOrFail($id);
        $post =  Post::where('title','Ullam soluta ut error a sed accusantium a.')->firstOrFail();

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
        $post = new Post();
        $post->title = $request->title;
        $post->content = $request->content;
        $post->save();
        // Post::create(

        // );
        dd('post créé');
    }
    public function contact(){
        return view('contact');
    } 
}
