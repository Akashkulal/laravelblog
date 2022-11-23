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
        $all_categories=Category::where('status','0')->get();
        $latest_posts=Post::where('status','0')->orderBy('created_at','DESC')->get()->take(15);
        return view('Frontend.index',compact('all_categories','latest_posts'));
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
            $latest_post=Post::where('category_id',$category->id)->where('status','0')->orderBy('created_at','DESC')->get()->take(15);
            return view('Frontend.Post.view',compact('post','latest_post'));
        }
        else{
            return redirect('/');
        }
    }
}
