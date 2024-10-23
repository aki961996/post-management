<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index(){
        $posts = Post::all();
        return view('post.index', ['posts'=>$posts]);
    }

    public function add(){
        return view('post.add');
    }

    public function store(Request $request)
    {
        // Validate the form data
        $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date',
            'author' => 'required|string',
            'content'=>'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Handle the image upload
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName);
        } else {
            $imageName = null;
        }

        // Create a new post
        $post = new Post();
        $post->name = $request->name;
        $post->date = $request->date;
        $post->author = $request->author;
        $post->content= $request->content;
        $post->image = $imageName;
        $post->save(); 

        
        return response()->json(['success' => 'Post saved successfully!']);
    }

    public function edit(Post $post)
    {
        return response()->json($post);
    }


    public function update(Request $request, Post $post)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date',
            'author' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB Max
        ]);

        // Handle image upload if a new image is provided
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            $post->image = $request->file('image')->store('images', 'public');
        }

        $post->name = $request->name;
        $post->date = $request->date;
        $post->author = $request->author;
        $post->content = $request->content;
        $post->save();

        return response()->json(['success' => 'Post updated successfully.']);
    }

    
    public function destroy(Post $post)
    {
        // Delete the image if exists
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }
        $post->delete();

        return response()->json(['success' => 'Post deleted successfully.']);
    }


 
}
