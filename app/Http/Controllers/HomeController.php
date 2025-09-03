<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Slider};
use Illuminate\Support\Carbon;
use Intervention\Image\ImageManager;

class HomeController extends Controller
{
    
    //  Require authentication
    function __construct()
    {
        $this->middleware('auth');
    }

    
    function home_slider()
    {
        $sliders = Slider::latest()->get();
        return view('admin.slider.index', compact('sliders'));
    }

    function create_slider()
    {
         return view('admin.slider.create');
    }


    function add_slider(Request $request, ImageManager $image)
    {
           //  Validate
        $request->validate([
            'title'   => 'required|unique:sliders|min:4',
            'description'  => 'nullable',
            'image'  => 'required|mimes:jpg,jpeg,png|max:2048',
        ], [
            'image.mimes'   => 'Only JPG, JPEG and PNG formats are allowed',
        ]);

        if ($request->hasFile('image')) {
            $slider_image = $request->file('image');

            // ✅ Generate safe filename
            $originalName   = pathinfo($slider_image->getClientOriginalName(), PATHINFO_FILENAME);
            $originalName   = preg_replace('/[^A-Za-z0-9_\-]/', '_', $originalName); // sanitize
            $extension      = strtolower($slider_image->getClientOriginalExtension());
            $datetime       = now()->format('Ymd_His');
            $name_gen       = $originalName . '_' . $datetime . '.' . $extension;

            // ✅ Define save path
            $last_img = public_path('image/slider/' . $name_gen);
            // dd($last_img);
            // ✅ Process with Intervention v3
            $img = $image->read($slider_image->getRealPath());

            $img->resize(1920, 1088);
            $img->save($last_img);

            // ✅ Store relative path for DB
            $db_path = 'image/slider/' . $name_gen;

            // Insert into DB
            Slider::insert([
                'title'  => $request->title,
                'description'  => $request->description,
                'image' => $db_path,
                'created_at'  => Carbon::now(),
            ]);
        }

        return redirect()->route('home.slider')->with('success', 'Slider Inserted Successfully');
    }
    
}