<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Category};
use Illuminate\Support\Facades\{Auth, DB};
use Illuminate\Support\Carbon;

class CategoryController extends Controller
{
    //  Require authentication
    function __construct()
    {
        $this->middleware('auth');
    }

    function all_category(){
        $categories = Category::latest()->paginate(5);
        $trashed_categories = Category::onlyTrashed()->latest()->paginate(5);

        // $categories = DB::table('categories')->latest()->get();

        // $categories = DB::table('categories')
        //             ->join('users', 'categories.user_id', 'users.id')
        //             ->select('categories.*', 'users.name')
        //             ->latest()->paginate(5);

        return view('admin.category.index', compact('categories', 'trashed_categories'));
    }


    function add_category(Request $request){
        $validated = $request->validate([
            'category_name' => 'required|unique:categories|max:255',
        ],
        [
            'category_name.required' => 'Please Input Category Name',
            'category_name.max' => 'Category Less than 255Chars',
        ]);

        // $data = array();
        // $data['category_name'] = $request->category_name;
        // $data['user_id'] = Auth::user()->id;
        // DB::table('categories')->insert($data);
        
        // Category::insert([
        //     'category_name' => $request->category_name,
        //     'user_id' => Auth::user()->id,
        //     'created_at' => Carbon::now()
        // ]);

        $category = new Category;
        $category->category_name = $request->category_name;
        $category->user_id = Auth::user()->id;
        $category->save();

        return Redirect()->back()->with('success', 'Category Inserted Successfully');
    }

    function edit_category($id){
        // $category = Category::find($id);
        $category = DB::table('categories')->where('id', $id)->first();
        return view('admin.category.edit', compact('category'));
    }
    
    function update_category(Request $request, $id){
        $validated = $request->validate([
            'category_name' => 'required|unique:categories|max:255',
        ],
        [
            'category_name.required' => 'Please Input Category Name',
            'category_name.max' => 'Category Less than 255Chars',
        ]);

        // $update = Category::find($id)->update([
        //     'category_name' => $request->category_name,
        //     'user_id' => Auth::user()->id,
        //     'created_at' => Carbon::now()
        // ]);

        // $category = Category::find($id);
        // $category->category_name = $request->category_name;
        // $category->user_id = Auth::user()->id;
        // $category->save();

        $data = array();
        $data['category_name'] = $request->category_name;
        $data['user_id'] = Auth::user()->id;
        $data['created_at'] = Carbon::now();
        DB::table('categories')->where('id', $id)->update($data);
        
        // Category::where('id', $id)->update($data);

        return Redirect()->route('all.category')->with('success', 'Category Updated Successfully');
    }

    function delete_category($id){
        $delete = Category::find($id)->delete();
        return Redirect()->back()->with('success', 'Category Soft Deleted Successfully');
    }

    function restore_category($id){
        $restore = Category::withTrashed()->find($id)->restore();
        return Redirect()->back()->with('success', 'Category Restored Successfully');
    }

    function pdelete_category($id){
        $pdelete = Category::onlyTrashed()->find($id)->forceDelete();
        return Redirect()->back()->with('success', 'Category Permanently Deleted Successfully');
    }

    
}