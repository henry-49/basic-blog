<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth,Hash};
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;

class ChangePasswordController extends Controller
{
    //
    function change_password()
    {
        return view('admin.body.change_password');
    }

    function update_password(Request $request)
    {
        $validate = $request->validate([
            'old_password' => 'required',
            'password' => 'required|confirmed',
        ],[
            'old_password.required' => 'Please Enter old password',
            'password.required' => 'Please Enter new password',
            'password.confirmed' => 'The password confirmation does not match.',
        ]);

        $hashedPassword = Auth::user()->password;

        // check if the give password match the old password
        if(Hash::check($request->old_password, $hashedPassword)){
            // find the authenticated user id
            $user = User::find(Auth::id());
            // hash the new password
            $user->password = Hash::make($request->password);
            // save the new user data
            $user->save();
            Auth::logout();

            return redirect()->route('login')->with('success', 'Password Changed Successfuly');
        } else{
            return redirect()->back()->with('error', 'Current Password Is Invalid');
        }
    }


    function profile_update()
    {

        if(Auth::user()){
            $user = User::find(Auth::user()->id);
            if($user){
                return view('admin.body.update_profile', compact('user'));
            }
        }
        
    }

    function user_profile_update(Request $request)
    {
        $user = User::find(Auth::user()->id);
         if($user){
                $user->name = $request->name;
                $user->email = $request->email;

                $user->save();
                return redirect()->back()->with('success', 'User Profile Updated Successfuly');
            }else{
            return redirect()->back()->with('error', 'Something Went Wrong');
        }
    }
    
}