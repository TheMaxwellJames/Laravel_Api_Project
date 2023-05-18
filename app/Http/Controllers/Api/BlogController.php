<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Blog;

class BlogController extends Controller
{
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required | max:250',
            'short_description' => 'required ',
            'long_description' => 'required',
            //'user_id' => 'required',
            'category_id' => 'required',
            'image' => 'required | image | mimes:jpg, bmp, png'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation errors',
                'errors' => $validator->messages()
            ], 422);
        }

        $image_name=time().'.'.$request->image->extension();
        $request->image->move(public_path('/uploads/blog_images'),$image_name);


        $blog=Blog::create([
            'title'=>$request->title,
            'short_description'=>$request->short_description,
            'long_description'=>$request->long_description,
            'user_id'=>$request->user()->id,
            'category_id'=>$request->category_id,
            'image'=>$image_name
        ]);

       // $blog->load('user', 'category');
        $blog->load('user:id,name,email', 'category:id,name');

        return response()->json([
            'message'=> 'Blog Successfully Created',
            'data'=>$blog
        ],200);
    }
}
