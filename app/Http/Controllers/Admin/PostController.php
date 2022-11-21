<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Admin\PostFormRequest;
use Illuminate\Support\Str;


class PostController extends Controller
{
    public function index()
    {
        $posts=Post::all();
        return view('Admin.Posts.index',compact('posts'));
    }

    //create
    public function create()
    {
        $category=Category::where('status','0')->get();
        return view('Admin.Posts.create',compact('category'));
    }

    public function store(PostFormRequest $request)
    {
        $data= $request->validated();

        $post=new post;
        $post->category_id=$data['category_id'];
        $post->name=$data['name'];
        $post->slug=Str::slug($data['slug']);
        $post->description=$data['description'];
        $post->yt_iframe=$data['yt_iframe'];
        $post->meta_title=$data['meta_title'];
        $post->meta_description=$data['meta_description'];
        $post->meta_keyword=$data['meta_keyword'];
        $post->status=$request->status==true?'1':'0';
        $post->created_by=Auth::user()->id;
        $post->save();

        return redirect('admin/posts')->with('message','Post added Successfully');
    }

    //edit

    public function edit($post_id)
    {
        $category=Category::where('status','0')->get();
        $post=Post::find($post_id);
        return view('Admin.Posts.edit',compact('post','category'));
    }

    public function update(PostFormRequest $request,$post_id)
    {
        $data= $request->validated();

        $post=post::find($post_id);
        $post->category_id=$data['category_id'];
        $post->name=$data['name'];
        $post->slug=Str::slug($data['slug']);
        $post->description=$data['description'];
        $post->yt_iframe=$data['yt_iframe'];
        $post->meta_title=$data['meta_title'];
        $post->meta_description=$data['meta_description'];
        $post->meta_keyword=$data['meta_keyword'];
        $post->status=$request->status==true?'1':'0';
        $post->created_by=Auth::user()->id;
        $post->update();

        return redirect('admin/posts')->with('message','Post updated Successfully');
    }

    //delete
    public function destroy($post_id)
    {
        $post=Post::find($post_id)->delete();
        return redirect('admin/posts')->with('message','Post Deleted Successfully');
    }
}
