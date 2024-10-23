<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    //    $commentNested = $comment->replies()->count();

    public function store(Request $request, Post $post){
        $request->validate([
            'contentt'=>'required'
        ]);

        Comment::create([
            'post_id'=> $post->id,
            'user_id'=> auth()->user()->id,
            'contentt'=> $post->id,
            'parent_id'=> $request->parent_id
        ]);

        return response()->json(['success'=> 'Comment added successfully']);

    }

    public function update(Request $request, Comment $comment){
        $this->authorize('update',$comment);
        $request->validate([
            'contentt'=>'required'
        ]);

        $comment->update($request->only('content'));
        return response()->json(['success'=>'Comment Update Successfully']);

    }

    public function destroy(Comment $comment){
        $this->authorize('delete', $comment);
        $comment->delete();
        return response()->json(['success'=>'Comment deteled Successfully']);
    }
}
