<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function index()
    {
        return view('Frontend.index');
    }

    //view category post
    public function viewCategoryPost($category_slug)
    {
        $category=Category::where('slug',$category_slug)->where('status','0')->first();
        if($category)
        {
            $post=Post::where('category_id',$category->id)->where('status','0')->get();
            return view('Frontend.Post.index');
        }
        else{
            return redirect('/');
        }
    }
}
