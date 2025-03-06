<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function menu()
    {
        return view('user.menu.menu');
    }

    public function breakfast()
    {
        return view('user.menu.breakfast');
    }

    public function lunch()
    {
        return view('user.menu.lunch');
    }

    public function dinner()
    {
        return view('user.menu.dinner');
    }
    
}

