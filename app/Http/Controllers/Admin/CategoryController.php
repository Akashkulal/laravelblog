<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Admin\CategoryFormRequest;
class CategoryController extends Controller
{
    public function index()
    {
        $category=Category::all();
        return view('Admin.Category.index',compact('category'));
    }

    //create category
    public function create()
    {
        return view('Admin.Category.create');
    }

    public function store(CategoryFormRequest $request)
    {
       $data=$request->validated();

       $category= new Category;
       $category->name=$data['name'];
       $category->slug=$data['slug'];
       $category->description=$data['description'];
       if($request->hasfile('images'))
       {
        $file=$request->file('images');
        $filename=time() . '.' . $file->getClientOriginalExtension();
        $file->move('uploads/category/',$filename);
        $category->images=$filename;
       }
       $category->meta_title=$data['meta_title'];
       $category->meta_description=$data['meta_description'];
       $category->meta_keyword=$data['meta_keyword'];

       $category->navbar_status=$request->navbar_status==true ? '1':'0';
       $category->status=$request->status==true?'1':'0';
       $category->created_by=Auth::user()->id;
       $category->save();

       return redirect('admin/category')->with('message','Category Added Successfully');
    }

    //edit
    public function edit($category_id)
    {
        $category=Category::find($category_id);
        return view('Admin.Category.edit',compact('category'));
    }

    //update
    public function update(CategoryFormRequest $request,$category_id)
    {
        $data=$request->validated();

        $category=Category::find($category_id);
       $category= new Category;
       $category->name=$data['name'];
       $category->slug=$data['slug'];
       $category->description=$data['description'];
       if($request->hasfile('images'))
       {
        $destination='uploads/category/'.$category->images;
        if(File::exists($destination))
        {
            File::delete($destination);
        }
        $file=$request->file('images');
        $filename=time() . '.' . $file->getClientOriginalExtension();
        $file->move('uploads/category/',$filename);
        $category->images=$filename;
       }
       $category->meta_title=$data['meta_title'];
       $category->meta_description=$data['meta_description'];
       $category->meta_keyword=$data['meta_keyword'];

       $category->navbar_status=$request->navbar_status==true ? '1':'0';
       $category->status=$request->status==true?'1':'0';
       $category->created_by=Auth::user()->id;
       $category->update();

       return redirect('admin/category')->with('message','Category Updated Successfully');
    }

    //delete
    public function destroy($category_id)
    {
        $category=Category::find($category_id);
        if($category)
        {
            $destination='uploads/category/'.$category->images;
            if(File::exists($destination))
            {
                File::delete($destination);
            }
            $category->delete($category_id);
            return redirect('admin/category')->with('message','Category deleted Successfully');
        }
        else{
            return redirect('admin/category')->with('message','No Category Id Found');
        }
    }
}
