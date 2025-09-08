<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Slider, Multipic};
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
        $validated = $request->validate([
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


      function edit_slider($id) {
        $slider = Slider::find($id);
        return view('admin.slider.edit', compact('slider'));
    }


     function update_slider(Request $request, $id, ImageManager $image) {
       // Validate
       $validated = $request->validate([
            'title'   => 'required|min:4',
            'description'  => 'nullable',
            'image'  => 'nullable|mimes:jpg,jpeg,png|max:2048',
        ], [
            'image.mimes'   => 'Only JPG, JPEG and PNG formats are allowed',
        ]);


       $slider = Slider::findOrFail($id);

        // Default: keep old image path
        $db_path = $slider->image;

        // If new image uploaded
        if ($request->hasFile('image')) {
            $slider_image = $request->file('image');

            // Delete old image if exists
            if ($slider->image && file_exists(public_path($slider->image))) {
                unlink(public_path($slider->image));
            }

            // Generate safe filename
            $originalName = pathinfo($slider_image->getClientOriginalName(), PATHINFO_FILENAME);
            $originalName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $originalName);
            $extension = strtolower($slider_image->getClientOriginalExtension());
            $datetime = now()->format('Ymd_His');
            $name_gen = $originalName . '_' . $datetime . '.' . $extension;

            // Absolute path for saving
            $save_path = public_path('image/slider/' . $name_gen);

            // Intervention Image v3
            $img = $image->read($slider_image->getRealPath());
            $img->resize(1920, 1088); // resize
            $img->save($save_path);

            // Update path for DB
            $db_path = 'image/slider/' . $name_gen;
        }

            // Update DB
            $slider->update([
                'title'  => $request->title,
                'description'  => $request->description,
                'image' => $db_path,
                'updated_at'  => Carbon::now(),
            ]);

        return redirect()->back()->with('success', 'Slider Updated Successfully');

    }


    function delete_slider($id) {
        // Find the slider
        $slider = Slider::find($id);

        if ($slider) {
            // Delete the image file
            if (file_exists(public_path($slider->image))) {
                unlink(public_path($slider->image));
            }

            // Delete the slider from the database
            $slider->delete();

            return redirect()->back()->with('success', 'Slider Deleted Successfully');
        }

        return redirect()->back()->with('error', 'Slider Not Found');
    }

    
    function portfolio(){
        $portfolio_pics = Multipic::all();
        return view('layouts.pages.portfolio', compact('portfolio_pics'));
    }
    

}