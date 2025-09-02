<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth};

class AdminController extends Controller
{
    //
    function logout()
    {
        Auth::logout();
        return Redirect()->route('login')->with('success', 'User Logout');
    }
}