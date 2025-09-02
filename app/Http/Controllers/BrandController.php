<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Brand};
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;


class BrandController extends Controller
{
     //  Require authentication
    function __construct()
    {
        $this->middleware('auth');
    }
    
    function all_brand() {
        $brands = Brand::latest()->paginate(5);
        return view('admin.brand.index', compact('brands'));
    }

    function add_brand(Request $request, ImageManager $image) {
         //  Validate
        $request->validate([
            'brand_name'   => 'required|unique:brands|min:4',
            'brand_image'  => 'required|mimes:jpg,jpeg,png|max:2048',
        ], [
            'brand_name.required' => 'Please Input Brand Name',
            'brand_name.unique'   => 'This Brand Name Already Exists',
            'brand_name.min'      => 'Brand must be longer than 4 characters',
            'brand_image.required'=> 'Please Upload a Brand Image',
            'brand_image.mimes'   => 'Only JPG, JPEG and PNG formats are allowed',
        ]);

        if ($request->hasFile('brand_image')) {
            $brand_image = $request->file('brand_image');

            // ✅ Generate safe filename
            $originalName   = pathinfo($brand_image->getClientOriginalName(), PATHINFO_FILENAME);
            $originalName   = preg_replace('/[^A-Za-z0-9_\-]/', '_', $originalName); // sanitize
            $extension      = strtolower($brand_image->getClientOriginalExtension());
            $datetime       = now()->format('Ymd_His');
            $name_gen       = $originalName . '_' . $datetime . '.' . $extension;

            // ✅ Define save path
            $last_img = public_path('image/brand/' . $name_gen);
            // dd($last_img);
            // ✅ Process with Intervention v3
            $img = $image->read($brand_image->getRealPath());

            $img->resize(300, 200);
            $img->save($last_img);

            // ✅ Store relative path for DB
            $db_path = 'image/brand/' . $name_gen;

            // Insert into DB
            Brand::insert([
                'brand_name'  => $request->brand_name,
                'brand_image' => $db_path,
                'created_at'  => Carbon::now(),
            ]);
        }

        return redirect()->back()->with('success', 'Brand Inserted Successfully');
    }

    function edit_brand($id) {
        $brand = Brand::find($id);
        return view('admin.brand.edit', compact('brand'));
    }


    function update_brand(Request $request, $id, ImageManager $image) {
       // Validate
        $validated = $request->validate([
            'brand_name'   => 'required|min:4',
            'brand_image' => 'nullable|mimes:jpg,jpeg,png|max:2048',
        ], [
            'brand_name.required' => 'Please Input Brand Name',
            'brand_name.min'      => 'Brand must be longer than 4 characters',
            'brand_image.mimes'   => 'Only JPG, JPEG and PNG formats are allowed',
        ]);


       $brand = Brand::findOrFail($id);

        // Default: keep old image path
        $db_path = $brand->brand_image;

        // If new image uploaded
        if ($request->hasFile('brand_image')) {
            $brand_image = $request->file('brand_image');

            // Delete old image if exists
            if ($brand->brand_image && file_exists(public_path($brand->brand_image))) {
                unlink(public_path($brand->brand_image));
            }

            // Generate safe filename
            $originalName = pathinfo($brand_image->getClientOriginalName(), PATHINFO_FILENAME);
            $originalName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $originalName);
            $extension = strtolower($brand_image->getClientOriginalExtension());
            $datetime = now()->format('Ymd_His');
            $name_gen = $originalName . '_' . $datetime . '.' . $extension;

            // Absolute path for saving
            $save_path = public_path('image/brand/' . $name_gen);

            // Intervention Image v3
            $img = $image->read($brand_image->getRealPath());
            $img->resize(300, 200); // resize
            $img->save($save_path);

            // Update path for DB
            $db_path = 'image/brand/' . $name_gen;
        }

            // Update DB
            $brand->update([
                'brand_name'  => $request->brand_name,
                'brand_image' => $db_path,
                'updated_at'  => Carbon::now(),
            ]);

        return redirect()->back()->with('success', 'Brand Updated Successfully');

    }


    function delete_brand($id) {
        // Find the brand
        $brand = Brand::find($id);

        if ($brand) {
            // Delete the image file
            if (file_exists(public_path($brand->brand_image))) {
                unlink(public_path($brand->brand_image));
            }

            // Delete the brand from the database
            $brand->delete();

            return redirect()->back()->with('success', 'Brand Deleted Successfully');
        }

        return redirect()->back()->with('error', 'Brand Not Found');
    }
}