<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Your admin dashboard logic here
        return view('admin.dashboard');
    }

    // Add other admin-related methods as needed
}
