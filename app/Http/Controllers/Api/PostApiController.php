<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $posts = Post::all();
        return response(["post"=>new PostResource($posts),'message'=>"Success"],200);
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

        $data = $request->all();
        $validation = Validator::make($data,[
            'title' => 'required',
            'body' => 'required'
        ]);

        if($validation->fails()){
            return response(['error' => $validation->errors(), "Validation Error"]);
        }

        $post = Post::create([
            'title' => $request->title,
            'body' => $request->body,
        ]);

        return response(['post' => new PostResource($post), 'message'=>"Success"],200);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //

        $post = Post::find($id);
        if(empty($post)){
            return response(['post'=>'not found', 'message'=>'Success'],200);
        }
        return response(['post' => new PostResource($post), 'message'=>'Success'],200);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        //

        $post->update($request->all());
        return response(['post'=> new PostResource($post), 'message'=> 'Success'],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
        $post->delete();
        return response(["message"=>'Success'],200);
    }
}
