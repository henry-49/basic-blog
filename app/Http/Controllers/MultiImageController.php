<?php

namespace App\Http\Controllers;

use App\Models\Multipic;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Intervention\Image\ImageManager;

class MultiImageController extends Controller
{
    //
    function multi_image()
    {
        $images = Multipic::all();
        return view('admin.multipic.index', compact('images'));
    }
    
    function add_multi_image(Request $request, ImageManager $image)
    {
        // ✅ Validate multiple images
        $validated = $request->validate([
            'images.*' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'images.*.required' => 'Please upload an image',
            'images.*.mimes'    => 'Only JPG, JPEG, PNG are allowed',
            'images.*.max'      => 'Each image must be under 2MB',
        ]);

        $images = $request->file('images');

        // Check if files are uploaded
        if ($request->hasFile('images')) {
            foreach ($images as $multi_img) {

            // ✅ Generate safe filename
            $originalName   = pathinfo($multi_img->getClientOriginalName(), PATHINFO_FILENAME);
            $originalName   = preg_replace('/[^A-Za-z0-9_\-]/', '_', $originalName); // sanitize
            $extension      = strtolower($multi_img->getClientOriginalExtension());
            $datetime       = now()->format('Ymd_His');
            $name_gen       = $originalName . '_' . $datetime . '.' . $extension;

            // dd($name_gen);
            // ✅ Define save path
            $last_img = public_path('image/multi/' . $name_gen);
            //  dd($last_img);
            // ✅ Process with Intervention v3
            $img = $image->read($multi_img->getRealPath());

            $img->resize(300, 200);
            $img->save($last_img);

            // ✅ Store relative path for DB
            $db_path = 'image/multi/' . $name_gen;

                // Store relative path in DB
                Multipic::insert([
                    'image' => $db_path,
                    'created_at' => Carbon::now(),
                ]);
            }
        }

        return redirect()->back()->with('success', 'Multiple Images Uploaded Successfully');
    }
}
