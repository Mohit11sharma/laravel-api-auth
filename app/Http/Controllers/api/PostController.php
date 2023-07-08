<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostStoreRequest;
use App\Models\Post;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $post = Post::get();
        return response()->json($post, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'title' => 'required',
            'description' => 'required|max:255',
            'image' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        try{
            if ($request->hasFile('image')) {
                $files = $request->file('image');
                $fileName = $files->hashName();
                $files->store('images', 'public', $fileName);
                $data['image'] = $fileName;
            }
            $post = Post::create([
                "user_id" => $request->user_id,
                "title" => $request->title,
                "description" => $request->description,
                "image" => $fileName,
            ]);

            return response()->json(['data'=> 'Post Add Successfully'], 200);
        }catch(\Throwable $th){
            return response()->json(['data'=> 'Post Add Failed'], 200);
        }

    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post =Post::find($id);
        return response()->json($post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostStoreRequest $request, $id)
    {
        try{
            if ($request->hasFile('image')) {
                $files = $request->file('image');
                $fileName = $files->hashName();
                $files->store('images', 'public', $fileName);
                $data['image'] = $fileName;
            }
            $post = Post::find($id);
            $post->user_id = $request->user_id;
            $post->title = $request->title;
            $post->description = $request->description;
            $post->image = $fileName;
            $post->update();
            return response()->json(['data'=> 'Post Update Successfully'], 200);
        }catch(\Throwable $th){
            return response()->json(['data'=> 'Post Update Failed'], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $post = Post::find($id);
        $post->delete();
        return response()->json(['data' => 'post  delete successfully'], 200);
    }
}
