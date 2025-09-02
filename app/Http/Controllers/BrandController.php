<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;


class BrandController extends Controller
{
    //
    function all_brand() {
        $brands = Brand::latest()->paginate(5);
        return view('admin.brand.index', compact('brands'));
    }

    function add_brand(Request $request) {
         // 1. Validate
        $request->validate([
            'brand_name'   => 'required|unique:brands|min:4',
            'brand_image'  => 'required|mimes:jpg,jpeg,png|max:2048',
        ], [
            'brand_name.required' => 'Please Input Brand Name',
            'brand_name.min'      => 'Brand Longer Than 4 Characters',
            'brand_image.required'=> 'Please upload a valid image',
        ]);

        if ($request->hasFile('brand_image')) {
        // 2. Handle Image Upload
        $brand_image = $request->file('brand_image');
        // $name_gen = hexdec(uniqid()).'.'.$brand_image->getClientOriginalExtension(); // 213123123.jpg
       // Get original name (without extension)
        $originalName = pathinfo($brand_image->getClientOriginalName(), PATHINFO_FILENAME);
        // Sanitize filename (remove spaces/special chars)
        $originalNameChar = preg_replace('/[^A-Za-z0-9_\-]/', '_', $originalName);
        // Get extension
        $extension = strtolower($brand_image->getClientOriginalExtension());
        // Add datetime to filename
        $datetime = now()->format('Ymd_His'); // e.g. 20250825_153045
        // Combine to new name
        $name_gen = $originalNameChar . '_' . $datetime . '.' . $extension;
        // Move file
        $brand_image->move(public_path('image/brand'), $name_gen);
        // Save path
        $last_img = 'image/brand/' . $name_gen;
        // dd($last_img);

        // 3. Insert into DB
        Brand::insert([
            'brand_name'  => $request->brand_name,
            'brand_image' => $last_img,
            'created_at'  => Carbon::now(),
        ]);
    }
        // 4. Redirect with success message
        return redirect()->back()->with('success', 'Brand Inserted Successfully');
    }

    function edit_brand($id) {
        $brand = Brand::find($id);
        return view('admin.brand.edit', compact('brand'));
    }


    function update_brand(Request $request, $id) {
       // 1. Validate
        $validated = $request->validate([
            'brand_name'   => 'required|min:4'
        ], [
            'brand_name.required' => 'Please Input Brand Name',
            'brand_name.min'      => 'Brand must be longer than 4 characters',
        ]);


        // $old_image = $request->old_image;
        // // 2. Handle Image Upload
        // $brand_image = $request->file('brand_image');
        // $name_gen = hexdec(uniqid());
        // $img_ext = strtolower($brand_image->getClientOriginalExtension());
        // $img_name = $name_gen.'.'.$img_ext;     // 213123123.jpg
        // $brand_image->move(public_path('image/brand'), $img_name);
        // $last_img = 'image/brand/'.$img_name;
        // Delete old image
        // unlink($old_image);


        // Always expect a new file
        $old_image = $request->old_image;

        if($request->hasFile('brand_image')) {
            $brand_image = $request->file('brand_image');

            // Generate safe filename
            $originalName = pathinfo($brand_image->getClientOriginalName(), PATHINFO_FILENAME);

            $originalNameChar = preg_replace('/[^A-Za-z0-9_\-]/', '_', $originalName);
            $extension = strtolower($brand_image->getClientOriginalExtension());
            $datetime = now()->format('Ymd_His');
            $name_gen = $originalNameChar . '_' . $datetime . '.' . $extension;

            // Move file to public/image/brand
            $brand_image->move(public_path('image/brand'), $name_gen);

            // New path
            $last_img = 'image/brand/' . $name_gen;



            // Delete old image if exists
            if ($brand_image && file_exists(public_path($old_image))) {
                unlink(public_path($old_image));
            }


            // Update DB
            Brand::find($id)->update([
                'brand_name'  => $request->brand_name,
                'brand_image' => $last_img,
                'updated_at'  => Carbon::now(),
            ]);

            //  Redirect with success
            return redirect()->back()->with('success', 'Brand Updated Successfully');

        } else {
            // No new image, just update name
            Brand::find($id)->update([
                'brand_name'  => $request->brand_name,
                'updated_at'  => Carbon::now(),
            ]);

            return redirect()->back()->with('success', 'Brand Updated Successfully');

        }

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