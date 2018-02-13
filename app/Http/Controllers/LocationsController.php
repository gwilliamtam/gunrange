<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LocationsController extends Controller
{
    protected $redirectTo = '/';

    //
    public function index(Request $request)
    {
        return view('locations');
    }
}
