<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\{Contact, ContactForm};
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

     // toastr
        $notification_success = array(
                'message' => 'Contact Inserted Successfully',
                'alert-type' => 'success'
            );

        return Redirect()->route('admin.contact')->with($notification_success);
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
      
         // toastr
        $notification_info = array(
                'message' => 'Contact Updated Successfully',
                'alert-type' => 'info',
                
            );

        return Redirect()->route('admin.contact')->with($notification_info);
    }


    function contact()
    {
        $contact_page = DB::table('contacts')->first();
        return view('layouts.pages.contact', compact('contact_page'));
    }


    function contact_form(Request $request)
    {
          $validated = $request->validate([
        'name'   => 'required',
        'email'  => 'required',
        'message'  => 'required',
        ],
        [
            'name.required' => 'Please Input Name',
            'email.required' => 'Please Input Email',
            'message.required' => 'Please Input Message',
        ]);
        
        ContactForm::insert([
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'message' => $request->message,
            'created_at' => Carbon::now()
        ]);

         // toastr
        $notification_success = array(
                'message' => 'Message Sent Successfully',
                'alert-type' => 'success',
                
            );

        return Redirect()->route('contact.page')->with($notification_success);
    }

    function admin_message()
    {
        $messages = ContactForm::all();
        return view('admin.contact.message', compact('messages'));
    }
    
    function delete_message($id) {
        // Find the message
        $deletemessage = ContactForm::find($id);
    
        // Delete the message from the database
        $deletemessage->delete();

          // toastr
        $notification_warning = array(
                'message' => 'Message Deleted Successfully',
                'alert-type' => 'warning',
                
            );
            
        return redirect()->back()->with($notification_warning);
    }

    function delete_about($id) {
        // Find the about
        $homecontact = Contact::find($id);
    
        // Delete the contact from the database
        $homecontact->delete();

             // toastr
        $notification_warning = array(
                'message' => 'Home Contact Deleted Successfully',
                'alert-type' => 'warning',
                
            );

        return redirect()->back()->with($notification_warning);
    }

}