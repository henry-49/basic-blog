<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\{Contact};
use Illuminate\Support\Facades\{Auth, DB};
use Illuminate\Support\Carbon;



class ContactController extends Controller
{

    function admin_contact() 
    {
        $contacts = Contact::all();
        return view('admin.contact.index', compact('contacts'));
    }

    function create_contact()
    {
        return view('admin.contact.create');
    }

    function add_contact(Request $request){
    $validated = $request->validate([
        'phone'   => 'required|unique:contacts|min:4',
        'email'  => 'required|unique:contacts',
        'address'  => 'required',
    ],
    [
        'address.required' => 'Please Input Address',
        'email.required' => 'Please Input Email',
    ]);
    
    Contact::insert([
        'phone' => $request->phone,
        'email' => $request->email,
        'address' => $request->address,
        'created_at' => Carbon::now()
    ]);


    return Redirect()->route('admin.contact')->with('success', 'Contact Inserted Successfully');
    }

    function edit_contact($id){
        
        $homecontact = DB::table('contacts')->where('id', $id)->first();
        return view('admin.contact.edit', compact('homecontact'));
    }
    
    function update_contact(Request $request, $id){
      $validated = $request->validate([
        'phone'   => 'required|min:4',
        'email'  => 'required',
        'address'  => 'required',
        ],
        [
            'address.required' => 'Please Input Address',
            'email.required' => 'Please Input Email',
        ]);
    

        $update = Contact::find($id)->update([
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'updated_at' => Carbon::now()
        ]);
      

        return Redirect()->route('admin.contact')->with('success', 'Contact Updated Successfully');
    }


    function contact()
    {
        $contact_page = DB::table('contacts')->first();
        return view('layouts.pages.contact', compact('contact_page'));
    }

    function delete_about($id) {
        // Find the about
        $homecontact = Contact::find($id);
    
        // Delete the contact from the database
        $homecontact->delete();

        return redirect()->back()->with('success', 'Home Contact Deleted Successfully');
    }

}