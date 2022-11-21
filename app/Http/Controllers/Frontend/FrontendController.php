<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Post;

class FrontendController extends Controller
{
    public function index()
    {
        return view('Frontend.index');
    }

    //view category post
    public function viewCategoryPost(string $category_slug)
    {
        $category=Category::where('slug',$category_slug)->where('status','0')->first();
        if($category)
        {
            $post=Post::where('category_id',$category->id)->where('status','0')->paginate(2);
            return view('Frontend.Post.index',compact('post','category'));
        }
        else{
            return redirect('/');
        }
    }

    //view post slug
    public function viewPost(string $category_slug,string $post_slug)
    {
        $category=Category::where('slug',$category_slug)->where('status','0')->first();
        if($category)
        {
            $post=Post::where('category_id',$category->id)->where('slug',$post_slug)->where('status','0')->first();
            return view('Frontend.Post.view',compact('post'));
        }
        else{
            return redirect('/');
        }
    }
}
