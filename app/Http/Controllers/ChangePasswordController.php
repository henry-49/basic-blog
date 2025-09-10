<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChangePasswordController extends Controller
{
    //
    function change_password()
    {
        return view('admin.body.change_password');
    }
    
}