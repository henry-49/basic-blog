<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{About};
use Illuminate\Support\Facades\{Auth, DB};
use Illuminate\Support\Carbon;

class AboutController extends Controller
{
    
    //  Require authentication
    function __construct()
    {
        $this->middleware('auth');
    }

    function home_about()
    {
        $homeabout = About::latest()->get();
        return view('admin.home.index', compact('homeabout'));
    }

    function create_about()
    {
        return view('admin.home.create');
    }

       function add_about(Request $request){
        $validated = $request->validate([
            'title'   => 'required|unique:abouts|min:4',
            'short_description'  => 'nullable',
            'long_description'  => 'nullable',
        ],
        [
            'title.required' => 'Please Input Title',
            'title.max' => 'Tite Longer than 4Chars',
        ]);
        
        About::insert([
            'title' => $request->title,
            'short_description' => $request->short_description,
            'long_description' => $request->long_description,
            'created_at' => Carbon::now()
        ]);


        return Redirect()->back()->with('success', 'About Inserted Successfully');
    }

    function edit_about($id){
        
        $homeabout = DB::table('abouts')->where('id', $id)->first();
        return view('admin.home.edit', compact('homeabout'));
    }
    
    function update_about(Request $request, $id){
        $validated = $request->validate([
            'title'   => 'required|unique:abouts|min:4',
        ],
        [
            'title.required' => 'Please Input Title',
            'title.max' => 'Tite Longer than 4Chars',
        ]);

        $update = About::find($id)->update([
            'title' => $request->title,
            'short_description' => $request->short_description,
            'long_description' => $request->long_description,
            'updated_at' => Carbon::now()
        ]);
      

        return Redirect()->route('home.about')->with('success', 'About Updated Successfully');
    }


    function delete_about($id) {
        // Find the about
        $homeabout = About::find($id);
        
            // Delete the brand from the database
            $homeabout->delete();

            return redirect()->back()->with('success', 'Home About Deleted Successfully');
        }
}